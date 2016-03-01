<?php

namespace app\models;

/**
 * Class FileInfo
 * @package app\models
 * @property string $filePath
 * @property string $originalName
 * @property string $hash
 * @property float $size
 * relations
 * @property FileFormat $fileFormat
 */
class FileInfo extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'files_info';
    }

    public function getFileFormat()
    {
        return $this->hasOne(FileFormat::className(), ['id' => 'file_formats_id']);
    }
}