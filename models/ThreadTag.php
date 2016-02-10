<?php

namespace app\models;

class ThreadTag extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'threads_tags';
    }
}