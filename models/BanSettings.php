<?php

namespace app\models;

/**
 * Class BanSettings
 * @package app\models
 * 
 * @property int $id
 * @property int $ip
 * @property int $subnet
 * @property string $name
 * @property string $session
 * @property string $message
 * @property int $fileInfoId
 * @property string $country
 * @property string $createdAt
 * @property string $updateAt
 * @property string $timestamp
 * @property string $reasonForUser
 * @property string $reasonForMod
 * @property int $bannedBy
 * @property bool $banUserOnViolation
 * 
 * @property $global
 * @property $boards
 * @property $threads
 * @property $chatPages
 */
class BanSettings extends ARExtended
{
    public static function tableName()
    {
        return 'bans_settings';
    }
    
    public function getGlobal()
    {
        return $this->hasOne(BanGlobal::className(), ['bans_settings_id' => 'id']);
    }

    public function getBoards()
    {
        return $this->hasMany(Board::className(), ['id' => 'board_id'])
            ->viaTable('bans_boards', ['bans_settings_id' => 'id']);
    }

    public function getThreads()
    {
        return $this->hasMany(Thread::className(), ['id' => 'thread_id'])
            ->viaTable('bans_threads', ['bans_settings_id' => 'id']);
    }

    public function getChatPages()
    {
        //TODO: Chat pages not implemented
        return false;
    }
    
}