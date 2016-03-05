<?php

namespace app\models;

/**
 * Class FileInfo
 * @package app\models
 * @property int $id
 * @property string $filePath
 * @property string $originalName
 * @property string $hash
 * @property float $size
 * relations
 * @property FileFormat $fileFormat
 */
class FileInfo extends ActiveRecordExtended
{
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

    public function upload()
    {
        /*$checkSum = md5_file($file->tempName);

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
            }*/
    }
}