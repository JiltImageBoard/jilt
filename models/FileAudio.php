<?php

namespace app\models;

/**
 * Class FileAudio
 * @package app\models
 * @property string $filePath
 * @property string $originalName
 * @property string $hash
 * @property float $size
 * relations
 * @property FileInfo $fileInfo
 */
class FileAudio extends FileInfo
{
    public static function tableName()
    {
        return 'files_audio';
    }

    public function getFileInfo()
    {
        return $this->hasOne(FileInfo::className(), ['id' => ['files_info_id']]);
    }
}