<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class BoardSetting
 * @package app\models
 * @property string $description
 * @property int $min_file_size
 * @property int $max_file_size
 * @property string $min_image_resolution
 * @property string $max_image_resolution
 * @property int $max_message_length
 * @property int $max_threads_on_page
 * @property int $max_board_pages
 * @property int $thread_max_posts
 * @property string $default_name
 * @property bool $is_closed
 */
class BoardSettingsDefault extends ActiveRecord
{
    public static function tableName()
    {
        return 'board_settings_default';
    }
}