<?php

namespace app\models;

/**
 * Class FileFormat
 * @package app\models
 * @property int $id
 * @property string $extension
 * @property int $fileFormatId
 * @property string $fileType
 * relations
 * @property Board[] $boards
 * @propetry FileInfo[] $fileInfos
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

    public function getFileInfos()
    {
        return $this->hasMany(FileInfo::className(), ['file_formats_id' => 'id']);
    }
}