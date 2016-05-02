<?php

namespace app\common\classes;

use app\models\FileInfo;
use yii\base\Object;
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

    public function init()
    {
        parent::init();

        if (!empty($this->fileHash)) {
            $this->fileData = FileInfo::findOne(['hash' => $this->fileHash]);
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
}