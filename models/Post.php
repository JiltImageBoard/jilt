<?php

namespace app\models;

use app\common\interfaces\DeletableInterface;

/**
 * Class Post
 * @package app\models
 *
 * @property int $id
 * @property int $number
 * @property int $postDataId
 * relations
 * @property PostData $postData
 * @property Thread   $thread
 */

class Post extends ARExtended implements DeletableInterface
{
    public static function tableName()
    {
        return 'posts';
    }

    public function getPostData()
    {
        return $this->hasOne(PostData::className(), ['id' => 'post_data_id']);
    }

    public function getThread()
    {
        return $this->hasOne(Thread::className(), ['id' => 'thread_id']);
    }

    public static function getDeletedRows(Array &$carry)
    {
        $posts = static::find()->where(['is_deleted' => '1'])->all();

        if (empty($posts)) {
            return $carry;
        }

        foreach ($posts as $post) {
            $carry['postsIds'][] = $post->getPrimaryKey();
        }
    }

}