<?php

namespace app\models;

/**
 * Class ChatRights
 * @package app\models
 * relations
 * @property UserChatRights $userChatRights
 */
class ChatRights extends ActiveRecordExtended
{
    public function getUserChatRights()
    {
        return $this->hasMany(UserChatRights::tableName(), ['chat_rights_id' => 'id']);
    }
}