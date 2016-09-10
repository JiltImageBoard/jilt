<?php

namespace app\models;

/**
 * Class FileVideo
 * @package app\models
 * relations
 * @property FileInfo $fileInfo
 */
class FileVideo extends ARExtended
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