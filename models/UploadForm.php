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
}