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
     * @var UploadedFile
     */
    public $uploadedFile;

    /**
     * @var FileInfo
     */
    public $fileInfo;

    /**
     * @var string
     */
    public $fileHash;



    public function init()
    {
        parent::init();

        if (!empty($this->fileHash)) {
            $this->fileInfo = FileInfo::findOne(['hash' => $this->fileHash]);
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
                $files[] = new PostedFile(['uploadedFile' => $uploadedFile]);
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
        if (empty($this->uploadedFile)) {
            return $this->fileInfo ? true : false;
        }

        $file = $this->uploadedFile;
        $fileHash = md5_file($file->tempName);

        // just in case if file already exists
        $existingFileInfo = FileInfo::findOne(['hash' => $fileHash]);
        if ($existingFileInfo) {
            $this->fileInfo = $existingFileInfo;
            return true;
        }

        $filePath = Yii::getAlias('@files/' . $fileHash . '.' . $file->extension);
        if (!$file->saveAs($filePath)) {
            return false;
        }

        $mimeType = MimeType::findOne(['name' => FileHelper::getMimeType($filePath)]);

        $fileInfo = new FileInfo([
            'filePath' => $filePath,
            'originalName' => $file->name,
            'hash' => $fileHash,
            'mimeTypeId' => $mimeType->id,
            'size' => $file->size
        ]);

        $result = $fileInfo->save();
        $this->fileInfo = $result ? $fileInfo : null;
        return $result;
    }

    public function delete()
    {
        // if file was uploaded now (so already existing won't be affected)
        if ($this->uploadedFile && $this->fileInfo) {
            $this->fileInfo->delete();
        }
    }
}