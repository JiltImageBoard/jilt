<?php

namespace app\models;

class Tag extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'tags';
    }

    public function getBoards()
    {
        return $this->hasMany(Board::className(), ['id' => 'board_id'])
            ->viaTable('threads_tags', ['tag_id' => 'id']);
    }
}