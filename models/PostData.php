<?php

namespace app\models;

use app\common\classes\Date;
use app\common\classes\PostedFile;
use app\common\validators\PostedFileValidator;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\UploadedFile;

/**
 * Class PostData
 * @package app\models
 *
 * @property int    $id
 * @property string $name
 * @property string $messageText
 * @property string $subject
 * @property int    $ip
 * @property string $session
 * @property bool   $isPremoded
 * @property bool   $isModPost
 * @property bool   $isDeleted
 * @property Date   $createdAt
 * @property Date   $updatedAt
 * relations
 * @property FileInfo[] $fileInfos
 * @property Thread     $thread
 * @property Post       $post
 */
class PostData extends ARExtended
{
    /**
     * @var array
     */
    public $validationParams;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'post_data';
    }

    public function getThread()
    {
        return $this->hasOne(Thread::className(), ['post_data_id' => 'id']);
    }

    public function getPost()
    {
        return $this->hasOne(Thread::className(), ['post_data_id' => 'id']);
    }

    public function rules()
    {
        return [
            /*[
                'postedFiles',
                PostedFileValidator::className(),
                'skipOnEmpty'        => true,
                'mimeTypes'          => $this->postsSettings->mimeTypes,
                'maxFiles'           => $this->postsSettings->maxFiles,
                'minFileSize'        => $this->postsSettings->minFileSize,
                'maxFileSize'        => $this->postsSettings->maxFileSize,
                'minImageResolution' => $this->postsSettings->minImageResolution,
                'maxImageResolution' => $this->postsSettings->maxImageResolution,

            ]*/
        ];
    }

    public function getFileInfos()
    {
        return $this->hasMany(FileInfo::className(), ['id' => 'files_info_id'])
            ->viaTable('post_data_files_info', ['post_data_id' => 'id']);
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

    /**
     * @return Date
     */
    public function getCreatedAt()
    {
        return new Date($this->attributes['created_at']);
    }

    /**
     * @return string
     */
    public function getDefaultName()
    {
        $thread = $this->thread ?: $this->post->thread;
        $postsSettings = $thread->postsSettings ?: $thread->board->postsSettings;
        return $postsSettings->defaultName;
    }

    /**
     * @return string
     */
    public function getName()
    {
        $name = $this->attributes['name'];
        return !empty($name) ? $name : $this->getDefaultName();
    }
}