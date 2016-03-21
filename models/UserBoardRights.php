<?php

namespace app\models;

/**
 * Class UserBoardRights
 * @package app\models
 * relations
 * @property User $user
 * @property BoardRights $rights
 * @property Board $board
 */
class UserBoardRights extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'cp_users_board_rights';
    }
    
    public function getUser()
    {
        return $this->hasOne(User::tableName(), ['id' => 'user_id']);
    }

    public function getRights()
    {
        return $this->hasOne(BoardRights::tableName(), ['id' => 'board_rights_id']);
    }

    public function getBoard()
    {
        return $this->hasOne(Board::tableName(), ['id' => 'board_id']);
    }
}
