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
     * @var UploadedFile[] $files
     */
    public $files;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'post_data';
    }

    public function rules()
    {
        // TODO: we should get rule values from board config
        // TODO: webm files not loading for some reason
        return [
            [['files'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, htm', 'maxFiles' => 4]
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

    public function save($runValidation = true, $attributeNames = null)
    {
        $this->saveFiles();
        return parent::save($runValidation, $attributeNames);
    }

    private function saveFiles() {
        $fileIds = [];
        foreach ($this->files as $file) {
            /**
             * @var FileFormat $fileFormat
             * @var FileInfo $FileClass
             */
            $fileFormat = FileFormat::find()->where(['file_format' => $file->extension])->one();
            $FileClass = 'app\models\File' . ucfirst($fileFormat->fileType);
            $newfileInfo = $FileClass::saveFile($file);
            if ($newfileInfo)
                $fileIds[] = $newfileInfo->id;
            else
                $this->addError("files", "Error saving file");
        }
        $this->files = [];
 
        $this->addLazyRelation(FileInfo::className(), 'fileInfos', $fileIds);
        /*print_r("kek!" . PHP_EOL);
        print_r($this->lazyRelations);
        print_r("/kek!" . PHP_EOL);*/
    }
}