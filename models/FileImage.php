<?php

namespace app\models;
use yii\web\UploadedFile;

/**
 * Class FileVideo
 * @package app\models
 * @property int $filesInfoId
 * @property int $width
 * @property int $height
 * inherited
 * @property string $filePath
 * @property string $originalName
 * @property string $hash
 * @property float $size
 * relations
 * @property FileInfo $fileInfo
 */
class FileImage extends FileInfo
{
    const THUMB_MAX_SIZE = 285;

    public static function tableName()
    {
        return 'files_images';
    }

    public function getFileInfo()
    {
        return $this->hasOne(FileInfo::className(), ['id' => 'files_info_id']);
    }

    /**
     * @param UploadedFile $file
     * @return FileInfo|
     */
    public static function saveFile($file)
    {
        if ($fileInfo = parent::saveFile($file)) {
            $fileImage = new FileImage();
            list($fileImage->width, $fileImage->height) = getimagesize($fileInfo->filePath);
            $fileImage->filesInfoId = $fileInfo->id;
            $fileImage->save();

            // creating thumb
            $thumbPath = $file->baseName . '_' . $fileInfo->id . '_thumb' . '.' . $file->extension;
            $newWidth = $fileImage->width;
            $newHeight = $fileImage->height;
            $ratio = $fileImage->width / $fileImage->height;
            if ($fileImage->width > $fileImage->height) {
                if ($fileImage->width > static::THUMB_MAX_SIZE) {
                    $newWidth = static::THUMB_MAX_SIZE;
                    $newHeight = $newWidth / $ratio;
                }
            } else {
                if ($fileImage->height > static::THUMB_MAX_SIZE) {
                    $newHeight = static::THUMB_MAX_SIZE;
                    $newWidth = $newHeight * $ratio;
                }
            }

            $thumb = imagecreatetruecolor($newWidth, $newHeight);
            $source = imagecreatefromjpeg($fileInfo->filePath);
            imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $fileImage->width, $fileImage->height);

            return $fileInfo;
        }

        return false;
    }
}