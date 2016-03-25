<?php

namespace app\models;

use app\common\exceptions\NotImplementedException;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\debug\panels\ConfigPanel;
use yii\web\IdentityInterface;

/**
 * Class User
 * @package app\models
 * 
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $authKey
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * relations
 * @property UserBoardRights[] $boardRights
 * @property UserChatRights[] $chatRights
 */
class User extends ActiveRecordExtended implements IdentityInterface
{
    
    const SCENARIO_UPDATE = 'update';
    
    public static function tableName()
    {
        return 'cp_users';
    }

    public function getBoardRights()
    {
        return $this->hasMany(UserBoardRights::className(), ['user_id' => 'id']);
    }

    public function getChatRights()
    {
        return $this->hasMany(UserChatRights::className(), ['user_id' => 'id']);
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

    /**
     * @param int|string $id
     * @return null|User
     */
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @throws NotImplementedException
     * @return void
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotImplementedException();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->authKey = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }
}