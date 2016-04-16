<?php

namespace app\common\classes;

class Thumb
{
    public static function create($filePath)
    {
        $strategy = static::selectStrategy($filePath);
        if ($strategy) $strategy->execute();
    }

    /**
     * Selects proper strategy, depending on file extension
     * @param string $filePath
     * @return ThumbCreationStrategy
     */
    private static function selectStrategy($filePath)
    {
        if (!file_exists($filePath)) {
            print_r('FIle does not exists');
            return;
        }

        $pathInfo = pathinfo($filePath);
        $extension = $pathInfo['extension'];

        if (!$extension) {
            print_r('File format was not specified');
            return;
        }

        $ConcreteStrategy = __NAMESPACE__ . '\\' . ucfirst($extension) . 'ThumbCreationStrategy';
        if (!class_exists($ConcreteStrategy)) {
            print_r('Thumb creation strategy is not implemented for [' . $extension . '] files');
            return;
        }

        return new $ConcreteStrategy($filePath);
    }
}

abstract class ThumbCreationStrategy
{
    const THUMB_MAX_SIDE_LENGTH = 285;
    protected $sourceFilePath;
    protected $sourceWidth;
    protected $sourceHeight;
    protected $thumbWidth;
    protected $thumbHeight;
    protected $thumbPath;
    protected $thumbFile;

    /**
     * @param string $sourceFilePath
     */
    public function __construct($sourceFilePath)
    {
        $this->sourceFilePath = $sourceFilePath;
        $this->initSizes();
        $this->initThumbPath();
        $this->thumbFile = imagecreatetruecolor($this->thumbWidth, $this->thumbHeight);
    }

    protected function initSizes()
    {
        list($sourceWidth, $sourceHeight) = getimagesize($this->sourceFilePath);

        $newWidth = $sourceWidth;
        $newHeight = $sourceHeight;
        $ratio = $sourceWidth / $sourceHeight;
        if ($sourceWidth > $sourceHeight) {
            if ($sourceWidth > static::THUMB_MAX_SIDE_LENGTH) {
                $newWidth = static::THUMB_MAX_SIDE_LENGTH;
                $newHeight = $newWidth / $ratio;
            }
        } else {
            if ($sourceHeight > static::THUMB_MAX_SIDE_LENGTH) {
                $newHeight = static::THUMB_MAX_SIDE_LENGTH;
                $newWidth = $newHeight * $ratio;
            }
        }

        $this->sourceWidth = $sourceWidth;
        $this->sourceHeight = $sourceHeight;
        $this->thumbWidth = $newWidth;
        $this->thumbHeight = $newHeight;
    }

    protected function initThumbPath()
    {
        $pathInfo = pathinfo($this->sourceFilePath);
        $this->thumbPath = $pathInfo['filename'] . '_thumb' . '.' . $pathInfo['extension'];
    }

    abstract public function execute();
}

abstract class ImageThumbCreationStrategy extends ThumbCreationStrategy
{
    public function execute()
    {
        $imageCreateFunc = $this->getImageCreateFunc();
        $imageSaveFunc = $this->getImageSaveFunc();

        $sourceFile = $imageCreateFunc($this->sourceFilePath);
        // PSR-2 violation, i know, but.. 4 lines for 4 zeros? That's not okay.
        imagecopyresized(
            $this->thumbFile, $sourceFile, 0, 0, 0, 0,
            $this->thumbWidth, $this->thumbHeight, $this->sourceWidth, $this->sourceHeight
        );
        $imageSaveFunc($this->thumbFile, $this->thumbPath);
    }

    /**
     * @return string
     */
    abstract protected function getImageCreateFunc();

    /**
     * @return string
     */
    abstract protected function getImageSaveFunc();
}

class PngThumbCreationStrategy extends ImageThumbCreationStrategy
{
    protected function getImageCreateFunc()
    {
        return 'imagecreatefrompng';
    }

    protected function getImageSaveFunc()
    {
        return 'imagepng';
    }

}

class JpgThumbCreationStrategy extends ImageThumbCreationStrategy
{
    protected function getImageCreateFunc()
    {
        return 'imagecreatefromjpg';
    }

    protected function getImageSaveFunc()
    {
        return 'imagejpg';
    }

}

class JpegThumbCreationStrategy extends JpgThumbCreationStrategy {}

class GifThumbCreationStrategy extends ImageThumbCreationStrategy
{
    protected function getImageCreateFunc()
    {
        return 'imagecreatefromgif';
    }

    protected function getImageSaveFunc()
    {
        return 'imagegif';
    }

}