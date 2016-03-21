<?php

namespace app\models;

class UserBoardRights extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'cp_users_board_rights';
    }
    
    public function getUsers()
    {
        //
    }
    
}