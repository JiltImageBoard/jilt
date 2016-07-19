<?php

namespace app\models;

use app\common\classes\PostedFile;
use yii\base\Model;

class UploadForm extends Model
{
    /** @var PostedFile[] */
    public $files;

    /** @var PostsSettings */
    public $settings;

    public function rules()
    {
        return [];
    }

    /**
     * @return bool
     */
    public function save()
    {
        $saved = true;
        foreach ($this->files as $file) {
            if (!$file->save()) {
                $saved = false;
                break;
            }
        }

        // We should remove all saved files if something gone wrong
        if (!$saved) {
            foreach ($this->files as $file) {
                $file->delete();
            }
        }

        return $saved;
    }

    /* @return FileInfo[]  */
    public function getFileInfos()
    {
        $infos = [];
        foreach ($this->files as $file) {
            $infos[] = $file->fileInfo;
        }
        return $infos;
    }
}