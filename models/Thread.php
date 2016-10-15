<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use app\common\interfaces\DeletableInterface;


/**
 * Class Thread
 * @package app\models
 *
 * @property int    $id
 * @property int    $boardId
 * @property int    $number
 * @property bool   $isSticked
 * @property bool   $isLocked
 * @property bool   $isOpMarkEnabled
 * @property bool   $isChat
 * @property bool   $isDeleted
 * @property int    $postDataId
 * @property string $updatedAt
 * relations
 * @property Board         $board
 * @property PostData      $postData
 * @property Post[]        $posts
 * @property PostsSettings $postsSettings
 */
class Thread extends ARExtended implements DeletableInterface
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

    public function getPostsSettings()
    {
        return $this->hasOne(PostsSettings::className(), ['id' => 'posts_settings_id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => 'updated_at',
                'value' => (new \DateTime())->format('Y-m-d H:i:s')
            ]
        ];
    }

    public function rules()
    {
        return [
            ['is_chat', 'default', 'value' => '0'],
        ];
    }
    
    public static function getDeletedRows(Array &$carry)
    {
        $threads = self::find()->where(['is_deleted' => '1'])->all();

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
            $tagsArray = Tag::parse($this->postData->messageText);
            foreach ($tagsArray as $tag) {
                $this->link('tags', $tag);
            }
        }
    }

    public function delete($physically = false)
    {
        if ($physically) {
            $postData = $this->postData;
            return parent::delete() ? $postData->delete() : false;
        } else {
            $this->isDeleted = true;
            $this->save();
        }
    }


}
