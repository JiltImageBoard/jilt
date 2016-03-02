<?php

namespace app\models;

/**
 * Class FileVideo
 * @package app\models
 * @property string $filePath
 * @property string $originalName
 * @property string $hash
 * @property float $size
 * relations
 * @property FileInfo $fileInfo
 */
class FileVideo extends FileInfo
{
    public static function tableName()
    {
        return 'files_video';
    }

    public function getFileInfo()
    {
        return $this->hasOne(FileInfo::className(), ['id' => ['files_info_id']]);
    }
}