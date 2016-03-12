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
 * @property string $salt
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 *
 */
class User extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'cp_users';
    }

    public function getCpRights()
    {
        return false;
    }

    public function getBoardRights()
    {
        return false;
    }

    public function getChatRights()
    {
        return false;
    }

    public static function getUserBySession()
    {
        $username = \yii::$app->session->get('username');
        return $user = static::find()->where('username = :username', [':username' => $username])->one();
    }
    
    public function checkPassword($password, $userPassword)
    {
        return $password === $userPassword;
    }
    
    
    public function checkRights()
    {
        return false;
    }
    
    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'unique'],
            ['username', 'string', 'length' => [1, 255]],

            ['password', 'required'],
            ['password', 'string', 'length' => [1, 255]],

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
}