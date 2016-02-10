<?php

namespace app\models;

/**
 * Class FileFormat
 * @package app\models
 */
class FileFormat extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'file_formats';
    }

    public function getBoards()
    {
        return $this->hasMany(Board::className(), ['id' => 'board_id'])
            ->viaTable('boards_file_formats', ['file_format_id' => 'id']);
    }
}