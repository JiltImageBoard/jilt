<?php

namespace app\models;

/**
 * Class Post
 * @package app\models
 * relations
 * @property PostData $postData
 * @property Thread $thread
 */
class Post extends ActiveRecordExtended
{
    public function getPostData()
    {
        return $this->hasOne(PostData::className(), ['id' => 'post_data_id']);
    }

    public function getThread()
    {
        return $this->hasOne(Thread::className(), ['id' => 'thread_id']);
    }
}