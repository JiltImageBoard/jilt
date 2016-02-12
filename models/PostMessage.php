<?php

namespace app\models;

/**
 * Class PostMessage
 * @package app\models
 *
 * @property int $id
 * @property string $text
 */
class PostMessage extends ActiveRecordExtended
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'post_messages';
    }

}