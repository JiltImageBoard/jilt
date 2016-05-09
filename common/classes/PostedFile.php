<?php

namespace app\common\classes;

use app\models\FileInfo;
use app\models\MimeType;
use Yii;
use yii\base\Object;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Simple wrapper used for absctraction of whether file is uploaded or already exists
 * Class PostedFile
 * @package app\common\classes
 */
class PostedFile extends Object
{
    /**
     * @var UploadedFile|FileInfo
     */
    public $fileData;

    /**
     * @var string
     */
    public $fileHash;

    /**
     * @var
     */
    public $isNewFile;

    public function init()
    {
        parent::init();

        if (!empty($this->fileHash)) {
            $this->fileData = FileInfo::findOne(['hash' => $this->fileHash]);
        }

        if ($this->fileData instanceof UploadedFile) {
            $this->isNewFile = true;
        }
    }

    /**
     * @param int $filesCount
     * @return PostedFile[]
     */
    public static function getPostedFiles($filesCount)
    {
        $postData = \Yii::$app->request->post();

        $files = [];
        for ($i = 0; $i < $filesCount; $i++) {
            $uploadedFile = UploadedFile::getInstanceByName("file-{$i}");
            if ($uploadedFile) {
                $files[] = new PostedFile(['fileData' => $uploadedFile]);
            } elseif (!empty($postData["file-{$i}"])) {
                $files[] = new PostedFile(['fileHash' => $postData["file-{$i}"]]);
            }
        }

        return $files;
    }

    /**
     * Saves UploadedFile from fileData if exists and puts in it FileInfo
     * @return bool
     */
    public function save()
    {
        if (!$this->fileData instanceof UploadedFile) {
            return true;
        }

        /**
         * @var UploadedFile $file
         */
        $file = $this->fileData;
        $fileHash = md5_file($file->tempName);

        // just in case if file already exists
        $existingFileInfo = FileInfo::find()->where(['hash' => $fileHash])->one();
        if ($existingFileInfo) {
            $this->isNewFile = false;
            $this->fileData = $existingFileInfo;
            return true;
        }

        $filePath = Yii::getAlias('@files/' . $fileHash . '.' . $file->extension);
        if (!$file->saveAs($filePath)) {
            return false;
        }

        $mimeType = MimeType::findOne([
            'name' => FileHelper::getMimeType($filePath)
        ]);

        $fileInfo = new FileInfo([
            'filePath' => $filePath,
            'originalName' => $file->name,
            'hash' => $fileHash,
            'mimeTypeId' => $mimeType->id,
            'size' => $file->size
        ]);

        $result = $fileInfo->save();
        $this->fileData = $result ? $fileInfo : null;
        return $result;
    }

    /**
     * @return FileInfo|null
     */
    public function getInfo()
    {
        if (!$this->fileData instanceof FileInfo) {
            return null;
        }

        return $this->fileData;
    }

    public function delete()
    {
        if ($this->isNewFile && $this->fileData instanceof FileInfo) {
            $this->fileData->delete();
        }
    }
}