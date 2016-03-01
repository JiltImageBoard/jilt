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
 * @property PostMessage $message
 * @property FileInfo[] $fileInfos
 */
class PostData extends ActiveRecordExtended
{
    /**
     * @var UploadedFile[] $files
     */
    public $files;

    public function rules()
    {
        // TODO: we should get rule values from board config
        // TODO: webm files not loading
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

    public function getMessage()
    {
        return $this->hasOne(PostMessage::className(), ['id' => 'message_id']);
    }

    public function getFileInfos()
    {
        return $this->hasMany(FileInfo::className(), ['id' => 'files_info_id'])
            ->viaTable('post_data_files_info', ['post_data_id' => 'id']);
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
                foreach ($this->files as $file) {
                    $checkSum = md5_file($file->tempName);

                    if (!FileInfo::find()->where(['hash' => $checkSum])->one()) {

                        $newId = FileInfo::find()->select('id')->max('id') + 1;
                        $filePath = $file->baseName . '_' . $newId . '.' . $file->extension;

                        if ($file->saveAs($filePath)) {
                            $fileFormat = FileFormat::find()->where(['file_format' => $file->extension])->one();
                            $newFileInfo = new FileInfo();
                            $newFileInfo->filePath = $filePath;
                            $newFileInfo->originalName = $file->baseName;
                            $newFileInfo->hash = $checkSum;
                            $newFileInfo->fileFormatId = $fileFormat->id;

                            $newFileInfo->save();
                        } else {
                            // TODO: error loading file json response
                            return 'error loading file';
                        }
                    }
                }

                return true;
        }

        return false;
    }
}