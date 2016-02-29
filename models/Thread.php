<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;


/**
 * Class Thread
 * @package app\models
 *
 * @property int $id
 * @property int $boardId
 * @property int $number
 * @property bool $isSticked
 * @property bool $isLocked
 * @property bool $isOpMarkEnabled
 * @property bool $isChat
 * @property bool $postDataId
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 *
 * @property \app\models\Board $board
 * @property \app\models\PostData $postData
 */
class Thread extends ActiveRecordExtended
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'threads';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoard()
    {
        return $this->hasOne(Board::className(), ['id' => 'board_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostData()
    {
        return $this->hasOne(PostData::className(), ['id' => 'post_data_id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('threads_tags', ['thread_id' => 'id']);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->isNewRecord) {
            $command =  \Yii::$app->db->createCommand("CALL mystored(
            :board_id, :is_sticked, :is_locked, :is_op_mark_enabled, :is_chat, :post_data_id)");
            $command->execute();
        } else {
            return parent::save($runValidation, $attributeNames);
        }
    }

    //TODO: Проверить что бехавор работает
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ]
        ];
    }
}