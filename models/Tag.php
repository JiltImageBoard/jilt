<?php

namespace app\models;

class Tag extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'tags';
    }
}