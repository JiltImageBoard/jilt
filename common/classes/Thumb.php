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
        if (file_exists($filePath)) {
            $pathInfo = pathinfo($filePath);
            $extension = $pathInfo['extension'];
            if ($extension) {
                $ConcreteStrategy = __NAMESPACE__ . '\\' . ucfirst($extension) . 'ThumbCreationStrategy';
                if (class_exists($ConcreteStrategy)) {
                    return new $ConcreteStrategy($filePath);
                } else {
                    // TODO: throw exception?
                    print_r('Thumb creation strategy is not implemented for [' . $extension . '] files');
                }
            } else {
                // TODO: throw exception
                print_r('File format was not specified');
            }
        }
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

    /**
     * @param string $sourceFilePath
     */
    public function __construct($sourceFilePath)
    {
        $this->sourceFilePath = $sourceFilePath;
        $this->initSizes();
        $this->initThumbPath();
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

class PngThumbCreationStrategy extends ThumbCreationStrategy
{
    public function execute()
    {
        $thumbFile = imagecreatetruecolor($this->thumbWidth, $this->thumbHeight);
        $sourceFile = imagecreatefrompng($this->sourceFilePath);
        // PSR-2 violation, i know, but.. 4 lines for 4 zeros? That's not okay.
        imagecopyresized(
            $thumbFile, $sourceFile, 0, 0, 0, 0,
            $this->thumbWidth, $this->thumbHeight, $this->sourceWidth, $this->sourceHeight
        );
        imagepng($thumbFile, $this->thumbPath);
    }
}

class JpgThumbCreationStrategy extends ThumbCreationStrategy
{
    public function execute()
    {
        $thumbFile = imagecreatetruecolor($this->thumbWidth, $this->thumbHeight);
        $sourceFile = imagecreatefromjpeg($this->sourceFilePath);
        imagecopyresized(
            $thumbFile, $sourceFile, 0, 0, 0, 0,
            $this->thumbWidth, $this->thumbHeight, $this->sourceWidth, $this->sourceHeight
        );
        imagejpeg($thumbFile, $this->thumbPath);
    }
}

class GifThumbCreationStrategy extends ThumbCreationStrategy
{
    public function execute()
    {
        $thumbFile = imagecreatetruecolor($this->thumbWidth, $this->thumbHeight);
        $sourceFile = imagecreatefromgif($this->sourceFilePath);
        imagecopyresized(
            $thumbFile, $sourceFile, 0, 0, 0, 0,
            $this->thumbWidth, $this->thumbHeight, $this->sourceWidth, $this->sourceHeight
        );
        imagegif($thumbFile, $this->thumbPath);
    }
}