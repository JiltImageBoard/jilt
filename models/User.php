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
 * @property BoardRights[] $boardRights
 * @property ThreadChatRights[] $chatRights
 */
class User extends ARExtended implements IdentityInterface
{
    const SCENARIO_UPDATE = 'update';
    protected $hidden = ['password', 'salt'];
    
    public static function tableName()
    {
        return 'cp_users';
    }

    /**
     * @param int $boardId
     * @return BoardRights[]
     */
    public function getBoardRights($boardId = null)
    {
        return $this->hasMany(BoardRights::className(), ['id' => 'board_rights_id'])
            ->viaTable('cp_users_board_rights', ['user_id' => 'id'], function ($query) use ($boardId) {
                if ($boardId != null && is_numeric($boardId))
                    $query->andWhere(['board_id' => $boardId]);
            });
    }

    /**
     * @param int $threadChatId
     * @return ThreadChatRights[]
     */
    public function getThreadChatRights($threadChatId = null)
    {
        return $this->hasMany(ThreadChatRights::className(), ['id' => 'thread_chat_id'])
            ->viaTable('cp_users_chat_rights', ['user_id' => 'id'], function ($query) use ($threadChatId) {
                if ($threadChatId != null && is_numeric($threadChatId))
                    $query->andWhere(['thread_chat_id' => $threadChatId]);
            });
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

    protected function setAuthKey($value)
    {
        return $this->authKey = $value;
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