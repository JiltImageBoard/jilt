<?php

namespace app\common\classes;

use app\common\exceptions\FileDoesNotExistException;
use app\common\exceptions\FileFormatWasNotSpecifiedException;
use app\common\exceptions\ThumbCreationStrategyIsNotImplementedException;

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
     * @throws FileDoesNotExistException|FileFormatWasNotSpecifiedException|ThumbCreationStrategyIsNotImplementedException
     * @return null|ThumbCreationStrategy
     */
    private static function selectStrategy($filePath)
    {
        if (!file_exists($filePath)) {
            throw new FileDoesNotExistException();
        }

        $pathInfo = pathinfo($filePath);
        $extension = $pathInfo['extension'];

        if (!$extension) {
            throw new FileFormatWasNotSpecifiedException();
        }

        $ConcreteStrategy = __NAMESPACE__ . '\\' . ucfirst($extension) . 'ThumbCreationStrategy';
        if (!class_exists($ConcreteStrategy)) {
            throw new ThumbCreationStrategyIsNotImplementedException($extension);
        }

        return new $ConcreteStrategy($filePath);
    }
}

abstract class ThumbCreationStrategy
{
    //TODO: THUMB_MAX_SIDE_LENGTH should get value from board settings
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
        //TODO: getimagesize in abstract class? 
        list($sourceWidth, $sourceHeight) = getimagesize($this->sourceFilePath);

        $newWidth = $sourceWidth;
        $newHeight = $sourceHeight;
        //TODO: This should be tested properly to work with all resolutions
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

class JpegThumbCreationStrategy extends ImageThumbCreationStrategy
{
    protected function getImageCreateFunc()
    {
        return 'imagecreatefromjpeg';
    }

    protected function getImageSaveFunc()
    {
        return 'imagejpeg';
    }

}

class JpgThumbCreationStrategy extends JpegThumbCreationStrategy {}

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