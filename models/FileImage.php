<?php

namespace app\models;

/**
 * Class FileVideo
 * @package app\models
 * @property string $filePath
 * @property string $originalName
 * @property string $hash
 * @property float $size
 * @property int $width
 * @property int $height
 * relations
 * @property FileInfo $fileInfo
 */
class FileImage extends FileInfo
{
    public static function tableName()
    {
        return 'files_images';
    }

    public function getFileInfo()
    {
        return $this->hasOne(FileInfo::className(), ['id' => 'files_info_id']);
    }
}