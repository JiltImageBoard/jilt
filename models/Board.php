<?php

namespace app\models;

use app\common\interfaces\DeletableInterface;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use app\common\interfaces;

/**
 * Class Board
 * @package app\models
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 * @property int $maxThreadsOnPage
 * @property int $maxBoardPages
 * @property int $threadMaxPosts
 * @property bool $isClosed
 * @property bool $isDeleted
 * @property int $maxFiles
 * 
 * relations
 * @property PostsSettings $postsSettings
 * @property Thread[] $threads
 * @property BoardCounter $counter
 */
class Board extends ActiveRecordExtended
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public static function tableName()
    {
        return 'boards';
    }

    public function getPostsSettings()
    {
        return $this->hasOne(PostsSettings::className(), ['id' => 'posts_settings_id']);
    }
    
    public function getThreads()
    {
        return $this->hasMany(Thread::className(), ['board_id' => 'id'])
            ->orderBy(['updated_at' => SORT_DESC]);
    }

    public function getCounter()
    {
        return $this->hasOne(BoardCounter::className(), ['board_id' => 'id']);
    }

    /**
     * TODO: most of these rules related to other Models
     * Rules for validation
     * @return array
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'unique'],
            ['name', 'string', 'length' => [1, 255]],

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
            
            [['mimeTypes', 'wordFilters', 'fileRatings', 'markupTypes'], 'required', 'on' => 'create'],
            [['mimeTypes', 'wordFilters', 'fileRatings', 'markupTypes'], 'each', 'rule' => ['integer'], 'on' => 'create'],
        ];
    }

    public function scenarios() {

        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_CREATE] = [
            'name', 'description', 'min_file_size', 'max_file_size', 'min_image_resolution', 'max_image_resolution', 
            'max_message_length', 'max_threads_on_page', 'max_board_pages', 'thread_max_posts', 'default_name', 'is_closed', 
            'mimeTypes', 'wordFilters', 'fileRatings', 'markupTypes'];
        $scenarios[self::SCENARIO_UPDATE] = [
            'name', 'description', 'min_file_size', 'max_file_size', 'min_image_resolution', 'max_image_resolution',
            'max_message_length', 'max_threads_on_page', 'max_board_pages', 'thread_max_posts', 'default_name', 'is_closed'
        ];

        return $scenarios;

    }
    
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (!parent::afterSave($insert, $changedAttributes)) {
            return false;
        }

        $boardCounter = new BoardCounter(['boardId' => $this->id]);
        $boardCounter->save();
    }


    // TODO: workaround used here to prevent calling getter in initRelationData: changed 'get*' to 'gat*
    public static function gatDeletedRows(Array &$carry)
    {
        $boards = self::find()->where(['is_deleted' => '1'])->all();
        
        if (empty($boards)) {
            return $carry;
        }
        
        foreach ($boards as $board) {
            $carry['boardsIds'][] = $board->id;
            
            foreach ($board->threads as $thread) {
                $carry['threadsIds'][] = $thread->id;
                
                foreach ($thread->posts as $post) {
                    $carry['postsIds'][] = $post->id;
                }
            }
        }
    }

}

