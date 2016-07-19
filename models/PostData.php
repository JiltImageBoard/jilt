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
 * @property string $messageText
 * @property string $subject
 * @property int $ip
 * @property string $session
 * @property bool $isPremoded
 * @property bool $isModPost
 * @property bool $isDeleted
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 * relations
 * @property FileInfo[] $fileInfos
 */
class PostData extends ARExtended
{
    /**
     * @var PostsSettings
     */
    public $postsSettings;

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
            /*[
                'postedFiles',
                PostedFileValidator::className(),
                'skipOnEmpty'        => true,
                'allowedMimeTypes'   => $this->postsSettings->mimeTypes,
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

    public function setFileInfos($ids)
    {
        if ($this->isNewRecord) $this->fileInfos = $ids;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if (!parent::save($runValidation, $attributeNames)) {
            return false;
        }

        if (!$this->saveFiles()) {
            parent::delete();
            return false;
        }

        return true;
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