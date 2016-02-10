<?php

namespace app\models;

/**
 * Class FileInfo
 * @package app\models
 */
class FileInfo extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'files_info';
    }
}