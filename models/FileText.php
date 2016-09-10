<?php

namespace app\models;

/**
 * Class FileDoc
 * @package app\models
 * relations
 * @property FileInfo $fileInfo
 */
class FileText extends ARExtended
{
    public static function tableName()
    {
        return 'files_text';
    }

    public function getFileInfo()
    {
        return $this->hasOne(FileInfo::className(), ['id' => ['files_info_id']]);
    }
}