<?php

namespace app\models;

/**
 * Class Thread
 * @package app\models
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

}