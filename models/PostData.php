<?php

namespace app\models;

use app\common\classes\PostedFile;
use app\common\validators\PostedFileValidator;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\UploadedFile;

/**
 * Class PostData
 * @package app\models
 *
 * @property int $id
 * @property string $name
 * @property int $messageId
 * @property string $subject
 * @property int $ip
 * @property string $session
 * @property bool $isPremoded
 * @property bool $isModPost
 * @property bool $isDeleted
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 * relations
 * @property PostMessage $postMessage
 * @property FileInfo[] $fileInfos
 */
class PostData extends ActiveRecordExtended
{
    /**
     * @var PostedFile[]
     */
    public $files;

    /**
     * @var array
     */
    public $fileValidationParams;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'post_data';
    }

    public function rules()
    {
        return [
            [
                'files',
                PostedFileValidator::className(),
                'skipOnEmpty' => true,
                'params' => $this->fileValidationParams
            ]
        ];
    }

    public function getPostMessage()
    {
        return $this->hasOne(PostMessage::className(), ['id' => 'message_id']);
    }

    public function getFileInfos()
    {
        return $this->hasMany(FileInfo::className(), ['id' => 'files_info_id'])
            ->viaTable('post_data_files_info', ['post_data_id' => 'id']);
    }

    public function setFileInfos($ids)
    {
        if ($this->isNewRecord) $this->fileInfos = $ids;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $this->saveFiles();
        return parent::save($runValidation, $attributeNames);
    }
    
    private function saveFiles() 
    {

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
}