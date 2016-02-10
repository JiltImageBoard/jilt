<?php

namespace app\models;

/**
 * Class FileAudio
 * @package app\models
 */
class FileAudio extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'files_audio';
    }
}