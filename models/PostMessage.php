<?php

namespace app\models;

/**
 * Class PostMessage
 * @package app\models
 *
 * @property int $id
 * @property string $text
 * relations
 * @property PostData[] $postData
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

    public function getPostData()
    {
        $this->hasMany(PostData::className(), ['message_id' => 'id']);
    }

}