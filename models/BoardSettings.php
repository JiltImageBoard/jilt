<?php

namespace app\models;


/**
 * Class BoardSetting
 * @package app\models
 * @property int $id
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
class BoardSettings extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'board_settings';
    }

    public function rules()
    {
        return [

            ['description', 'default', 'value' => ''],
            ['description', 'string', 'length' => [1, 255]],

            ['min_file_size', 'default', 'value' => '1'],
            ['min_file_size', 'number'],

            ['max_file_size', 'default', 'value' => '20971520'],
            ['max_file_size', 'number'],

            ['min_image_resolution', 'default', 'value' => '1x1'],
            ['min_image_resolution', 'string', 'length' => [1, 11]],

            ['max_image_resolution', 'default', 'value' => '5000x5000'],
            ['max_image_resolution', 'string', 'length' => [1, 11]],

            ['max_message_length', 'default', 'value' => '30000'],
            ['max_message_length', 'number'],

            ['max_threads_on_page', 'default', 'value' => '15'],
            ['max_threads_on_page', 'number'],

            ['max_board_pages', 'default', 'value' => '100'],
            ['max_board_pages', 'number'],

            ['thread_max_posts', 'default', 'value' => '500'],
            ['thread_max_posts', 'number'],

            ['default_name', 'string', 'length' => [1, 50]],

            ['is_closed', 'default', 'value' => '0'],
            ['is_closed', 'boolean'],

        ];
    }
}