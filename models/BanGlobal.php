<?php

namespace app\models;

/**
 * Class BanGlobal
 * @package app\models
 * 
 * @property int $id
 * @property int $ban_settings_id
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 */
class BanGlobal extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'bans_global';
    }
    
    
    
}