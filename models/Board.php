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
 * 
 * @property int $minFileSize
 * @property int $maxFileSize
 * @property string $minImageResolution
 * @property string $maxImageResolution
 * @property int $maxMessageLength
 * @property int $maxThreadsOnPage
 * @property int $maxBoardPages
 * @property int $threadMaxPosts
 * @property string $defaultName
 * @property bool $isClosed
 * @property bool $isDeleted
 * 
 * relations
 * @property \app\models\FileFormat[] $fileFormats
 * @property \app\models\WordFilter[] $wordFilters
 * @property \app\models\FileRating[] $fileRatings
 * @property \app\models\MarkupType[] $markupTypes
 * @property \app\models\Thread[] $threads
 * @property \app\models\BoardCounter $counter
 */
class Board extends ActiveRecordExtended implements DeletableInterface
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public static function tableName()
    {
        return 'boards';
    }
    
    public function getFileFormats()
    {
        return $this->hasMany(FileFormat::className(), ['id' => 'file_format_id'])
            ->viaTable('boards_file_formats', ['board_id' => 'id']);
    }

    /**
     * @param int[] $ids
     */
    public function setFileFormats($ids)
    {
        $this->fileFormats = $ids;
    }
    
    public function getWordFilters()
    {
        return $this->hasMany(WordFilter::className(), ['id' => 'wordfilter_id'])
            ->viaTable('boards_wordfilters', ['board_id' => 'id']);
    }

    /**
     * @param int[] $ids
     */
    public function setWordFilters($ids)
    {
        $this->wordFilters = $ids;
    }
    
    public function getFileRatings()
    {
        return $this->hasMany(FileRating::className(), ['id' => 'file_rating_id'])
            ->viaTable('boards_file_ratings', ['board_id' => 'id']);
    }

    /**
     * @param int[] $ids
     */
    public function setFileRatings($ids)
    {
        $this->fileRatings = $ids;
    }
    
    public function getMarkupTypes()
    {
        return $this->hasMany(MarkupType::className(), ['id' => 'markup_type_id'])
            ->viaTable('boards_markup_types', ['board_id' => 'id']);
    }

    /**
     * @param int[] $ids
     */
    public function setMarkupTypes($ids)
    {
        $this->markupTypes = $ids;
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
            
            [['fileFormats', 'wordFilters', 'fileRatings', 'markupTypes'], 'required', 'on' => 'create'],
            [['fileFormats', 'wordFilters', 'fileRatings', 'markupTypes'], 'each', 'rule' => ['integer'], 'on' => 'create'],
        ];
    }

    public function scenarios() {

        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_CREATE] = [
            'name', 'description', 'min_file_size', 'max_file_size', 'min_image_resolution', 'max_image_resolution', 
            'max_message_length', 'max_threads_on_page', 'max_board_pages', 'thread_max_posts', 'default_name', 'is_closed', 
            'fileFormats', 'wordFilters', 'fileRatings', 'markupTypes'];
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
        parent::afterSave($insert, $changedAttributes);
        $boardCounter = new BoardCounter(['board_id' => $this->id]);
        $boardCounter->save();
    }


    public function getDeletedRows(Array &$carry) 
    {
        $boards = $this->find()->where(['is_deleted' => '1'])->all();
        
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

