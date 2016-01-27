<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Board
 * @package app\models
 * @property string $name
 */
class Board extends ActiveRecord
{
    public static function tableName()
    {
        return 'boards';
    }

    public function getSettings()
    {
        return $this->hasOne(BoardSetting::className(), ['id' => 'settings_id']);
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'length' => [1, 255]]

        ];
    }

    public function load($data)
    {
        if (!empty($data)) {
            $this->setAttributes($data);
            return true;
        }
        return false;
    }
}