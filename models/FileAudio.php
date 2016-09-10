<?php

namespace app\models;

/**
 * Class FileAudio
 * @package app\models
 * relations
 * @property FileInfo $fileInfo
 */
class FileAudio extends ARExtended
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