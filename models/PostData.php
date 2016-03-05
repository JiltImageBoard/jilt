<?php

namespace app\models;
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
     * @var UploadedFile[] $filesToUpload
     */
    public $filesToUpload;

    public function rules()
    {
        // TODO: we should get rule values from board config
        // TODO: webm files not loading for some reason
        return [
            [['files'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, htm', 'maxFiles' => 4]
        ];
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'post_data';
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

    public function save($runValidation = true, $attributeNames = null)
    {
        $this->uploadFiles();
        return parent::save($runValidation, $attributeNames);
    }

    private function uploadFiles() {
        $fileIds = [];
        foreach ($this->filesToUpload as $file) {
            /**
             * @var FileFormat $fileFormat
             * @var FileInfo $fileClass
             */
            $fileFormat = FileFormat::find()->where(['file_format' => $file->extension])->one();
            $FileClassName = 'File' . ucfirst($fileFormat->fileType);
            $fileClass = new $FileClassName();
            if ($fileClass->upload())
                $relatedIds[] = $fileClass->id;
        }

        $this->addLazyRelation(FileInfo::className(), 'fileInfos', $fileIds);
    }
}