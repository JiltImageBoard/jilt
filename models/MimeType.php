<?php

namespace app\models;

/**
 * Class MimeType
 * @package app\models
 * @property int $id
 * @property string name
 * relations
 * @property Board[] $boards
 * @propetry FileInfo[] $fileInfos
 */
class MimeType extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'mime_types';
    }

    public function getBoards()
    {
        return $this->hasMany(Board::className(), ['id' => 'board_id'])
            ->viaTable('boards_mime_types', ['mime_type_id' => 'id']);
    }

    public function getFileInfos()
    {
        return $this->hasMany(FileInfo::className(), ['file_formats_id' => 'id']);
    }
}