<?php

namespace app\models;

/**
 * Class FileDoc
 * @package app\models
 * @package app\models
 * @property string $filePath
 * @property string $originalName
 * @property string $hash
 * @property float $size
 * relations
 * @property FileInfo $fileInfo
 */
class FileDoc extends FileInfo
{
    public static function tableName()
    {
        return 'files_doc';
    }

    public function getFileInfo()
    {
        return $this->hasOne(FileInfo::className(), ['id' => ['files_info_id']]);
    }
}