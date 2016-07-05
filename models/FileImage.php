<?php

namespace app\models;
use app\common\classes\Thumb;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\web\UploadedFile;
use yii\imagine\Image;

/**
 * Class FileVideo
 * @package app\models
 * @property int $filesInfoId
 * @property int $width
 * @property int $height
 * relations
 * @property FileInfo $fileInfo
 */
class FileImage extends ActiveRecordExtended
{
    const THUMB_MAX_SIDE_LENGTH = 285;
    const THUMB_QUALITY = 80;

    public static function tableName()
    {
        return 'files_images';
    }

    public function getFileInfo()
    {
        return $this->hasOne(FileInfo::className(), ['id' => 'files_info_id']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        list($sourceWidth, $sourceHeight) = getimagesize($this->fileInfo->filePath);
        $this->width = $sourceWidth;
        $this->height = $sourceHeight;

        return $this->generateThumb();
    }

    public function beforeDelete()
    {
        unlink($this->getThumbPath());
        return parent::beforeDelete();
    }

    public function getThumbSizes()
    {
        $width = $this->width;
        $height = $this->height;
        $ratio = $this->width / $this->height;
        if ($this->width > $this->height) {
            if ($this->width > FileImage::THUMB_MAX_SIDE_LENGTH) {
                $width = FileImage::THUMB_MAX_SIDE_LENGTH;
                $height = $width / $ratio;
            }
        } else {
            if ($this->height > FileImage::THUMB_MAX_SIDE_LENGTH) {
                $height = FileImage::THUMB_MAX_SIDE_LENGTH;
                $width = $height * $ratio;
            }
        }

        return [$width, $height];
    }

    public function getThumbPath()
    {
        if (!$this->fileInfo) {
            return null;
        }

        list($fileName, $fileExtension) = explode('.', $this->fileInfo->filePath);
        return $fileName . '_thumb.' . $fileExtension;
    }

    public function generateThumb()
    {
        $sourcePath = $this->fileInfo->filePath;
        $thumbPath = $this->getThumbPath();
        list($thumbwidth, $thumbHeight) = $this->getThumbSizes();

        try {
            Image::thumbnail($sourcePath, $this->width, $this->height)
                ->resize(new Box($thumbwidth, $thumbHeight))
                ->save($thumbPath, ['quality' => FileImage::THUMB_QUALITY]);

        } catch (\Exception $e) {
            return false;
        }

        return is_readable($thumbPath);
    }
}