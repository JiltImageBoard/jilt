<?php

namespace app\models;

use yii\web\UploadedFile;

/**
 * Class FileInfo
 * @package app\models
 * @property int $id
 * @property int $fileFormatsId
 * @property string $filePath
 * @property string $originalName
 * @property string $hash
 * @property float $size
 * relations
 * @property FileFormat $fileFormat
 */
class FileInfo extends ActiveRecordExtended
{
    /**
     * @var bool if file was saved right now and was not yielded from the db search
     */
    public $isNewFile = false;

    public static function tableName()
    {
        return 'files_info';
    }

    public function __construct($config = [])
    {
        parent::__construct($config);
        if (static::className() !== FileInfo::className()) {
            $this->delegatedFields += [
                'filePath' => 'fileInfo',
                'originalName' => 'fileInfo',
                'hash' => 'fileInfo',
                'size' => 'fileInfo',
                'fileFormat' => 'fileInfo'
            ];
        }
    }

    public function getFileFormat()
    {
        return $this->hasOne(FileFormat::className(), ['id' => 'file_formats_id']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->isNewFile = $this->getIsNewRecord();
        return true;
    }

    /**
     * @param UploadedFile $file
     * @return FileInfo|bool
     */
    public static function saveFile($file)
    {
        $checkSum = md5_file($file->tempName);

        $fileWithSameHash = FileInfo::find()->where(['hash' => $checkSum])->one();

        if ($fileWithSameHash) {
            return $fileWithSameHash;
        }

        $newId = FileInfo::find()->select('id')->max('id') + 1;
        $filePath = $file->baseName . '_' . $newId . '.' . $file->extension;

        if (!$file->saveAs($filePath)) {
            return false;
        }

        $fileFormat = FileFormat::find()->where(['extension' => $file->extension])->one();
        $newFileInfo = new FileInfo();
        $newFileInfo->id = $newId;
        $newFileInfo->filePath = $filePath;
        $newFileInfo->originalName = $file->baseName;
        $newFileInfo->hash = $checkSum;
        $newFileInfo->fileFormatsId = $fileFormat->id;
        $newFileInfo->size = $file->size;

        if (!$newFileInfo->save()) {
            return false;
        }

        return $newFileInfo;
    }
}
