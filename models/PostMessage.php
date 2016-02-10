<?php

namespace app\models;

class PostMessage extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'post_messages';
    }
}