<?php

namespace app\models;

/**
 * Class FileImage
 * @package app\models
 */
class FileImage extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'files_images';
    }
}