<?php

namespace app\models;

/**
 * Class ThreadChatRights
 * @package app\models
 * @property int $id
 * @property bool $canDeletePosts
 * @property bool $canEditPosts
 * @property bool $canEditPages
 * @property bool $canBan
 * relations
 * @property User[] $users
 * @property Thread[] $threadChats
 */
class ThreadChatRights extends ARExtended
{
    public static function tableName()
    {
        return 'cp_chat_rights';
    }

    /**
     * @param int $threadChatId
     * @return User[]
     */
    public function getUsers($threadChatId = null)
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('cp_users_chat_rights', ['chat_rights_id' => 'id'], function ($query) use ($threadChatId) {
                if ($threadChatId != null && is_numeric($threadChatId))
                    $query->andWhere(['thread_chat_id' => $threadChatId]);
            });
    }

    /**
     * @param int $userId
     * @return Board[]
     */
    public function getThreadChats($userId = null)
    {
        return $this->hasMany(Thread::className(), ['id' => 'thread_chat_id'])
            ->viaTable('cp_users_chat_rights', ['chat_rights_id' => 'id'], function ($query) use ($userId) {
                if ($userId != null && is_numeric($userId))
                    $query->andWhere(['user_id' => $userId]);
            });
    }
}