<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Thread
 * @package app\models
 */
class Thread extends ActiveRecord
{
    public static function tableName()
    {
        return 'threads';
    }
}