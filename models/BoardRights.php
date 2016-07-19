<?php

namespace app\models;

/**
 * Class BoardRights
 * @package app\models
 * @property int $id
 * @property bool $canDeleteThreads
 * @property bool $canEditThreads
 * @property bool $canLockThreads
 * @property bool $canStickThreads
 * @property bool $canDeletePosts
 * @property bool $canEditPosts
 * @property bool $canBan
 * @property bool $canEditBoardSettings
 * relations
 * @property User[] $users
 * @property Board[] $boards
 */
class BoardRights extends ARExtended
{
    public static function tableName()
    {
        return 'cp_board_rights';
    }

    /**
     * @param int $boardId
     * @return User[]
     */
    public function getUsers($boardId = null)
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('cp_users_board_rights', ['board_rights_id' => 'id'], function ($query) use ($boardId) {
                if ($boardId != null && is_numeric($boardId))
                    $query->andWhere(['board_id' => $boardId]);
            });
    }

    /**
     * @param int $userId
     * @return Board[]
     */
    public function getBoards($userId = null)
    {
        return $this->hasMany(Board::className(), ['id' => 'board_id'])
            ->viaTable('cp_users_board_rights', ['board_rights_id' => 'id'], function ($query) use ($userId) {
                if ($userId != null && is_numeric($userId))
                    $query->andWhere(['user_id' => $userId]);
            });
    }
}