<?php

namespace app\models;

class UserCpRights extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'cp_users_cp_rights';
    }
    
    public function getUsers()
    {
        //
    }
    
}