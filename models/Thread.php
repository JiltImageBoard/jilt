<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use app\common\interfaces\DeletableInterface;


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
 * @property bool $isDeleted
 * @property int $postDataId
 * @property \DateTime $updatedAt
 * 
 * @property \app\models\Board $board
 * @property \app\models\PostData $postData
 * @property \app\models\Post $posts
 */
class Thread extends ActiveRecordExtended implements DeletableInterface
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'threads';
    }

    public function getBoard()
    {
        return $this->hasOne(Board::className(), ['id' => 'board_id']);
    }

    public function getPostData()
    {
        return $this->hasOne(PostData::className(), ['id' => 'post_data_id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('threads_tags', ['thread_id' => 'id']);
    }
    
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['thread_id' => 'id']);
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

    public function rules()
    {
        return [
                ['is_chat', 'default', 'value' => '0'],
            ];
    }
    
    public function getDeletedRows(Array &$carry)
    {
        $threads = $this->find()->where(['is_deleted' => '1'])->all();

        if (empty($threads)) {
            return $carry;
        }
        
        foreach ($threads as $thread) {
            $carry['threadsIds'][] = $thread->id;

            foreach ($thread->posts as $post) {
                $carry['postsIds'][] = $post->id;
            }
        }
        
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $tagsArray = Tag::parse($this->postData->postMessage->text);
            foreach ($tagsArray as $tag) {
                $this->link('tags', $tag);
            }
            
        }
    }
}
