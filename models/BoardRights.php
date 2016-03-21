<?php

namespace app\models;

/**
 * Class BoardRights
 * @package app\models
 * relations
 * @property UserBoardRights[] $userBoardRights
 */
class BoardRights extends ActiveRecordExtended
{
    public function getUserBoardRights()
    {
        return $this->hasMany(UserBoardRights::tableName(), ['board_rights_id' => 'id']);
    }
}