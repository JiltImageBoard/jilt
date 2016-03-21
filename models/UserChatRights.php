<?php

namespace app\models;

/**
 * Class UserChatRights
 * @package app\models
 * relations
 * @property User $user
 * @property ChatRights $chatRights
 * @property Thread $threadChat
 */
class UserChatRights extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'cp_users_chat_rights';
    }
    
    public function getUser()
    {
        return $this->hasOne(User::tableName(), ['id' => 'user_id']);
    }

    public function getRights()
    {
        return $this->hasOne(ChatRights::tableName(), ['id' => 'chat_rights_id']);
    }

    public function getThreadChat()
    {
        return $this->hasOne(Thread::tableName(), ['id' => 'thread_chat_id']);
    }
}