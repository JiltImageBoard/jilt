<?php

namespace app\models;

class UserChatRights extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'cp_users_chat_rights';
    }
    
    public function getUsers()
    {
        //
    }
    
}