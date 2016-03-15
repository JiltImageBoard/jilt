<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Class User
 * @package app\models
 * 
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 *
 */
class User extends ActiveRecordExtended
{
    
    const SCENARIO_UPDATE = 'update';
    
    public static function tableName()
    {
        return 'cp_users';
    }

    public function getCpRights()
    {
        return $this->hasOne(UserCpRights::className(), ['user_id' => 'id']);
    }

    public function getBoardRights()
    {
        return $this->hasOne(UserBoardRights::className(), ['user_id' => 'id']);
    }

    public function getChatRights()
    {
        return $this->hasOne(UserChatRights::className(), ['user_id' => 'id']);
    }

    public static function getUserBySession()
    {
        $username = \yii::$app->session->get('username');
        return $user = static::find()->where('username = :username', [':username' => $username])->one();
    }
    
    public function checkRights()
    {
        return false;
    }
    
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['username', 'unique'],
            ['username', 'string', 'length' => [1, 255]],
            
            ['password', 'string', 'length' => [1, 255]],
            
//            Должен валидироваться, но в данный момент new_password - safe аттрибут
//            ['new_password', 'required'/*, 'on' => self::SCENARIO_UPDATE*/],
//            ['new_password', 'string', 'length' => [1, 255]],

            ['email', 'required'],
            ['email', 'unique'],
            ['email', 'email']
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    public function scenarios()
	{
        $scenarios = parent::scenarios();
        $scenarios['default'] = ['username', 'password', 'email'];
        $scenarios[self::SCENARIO_UPDATE] = ['username','password', 'new_password', 'email'];
        return $scenarios;
    }
}