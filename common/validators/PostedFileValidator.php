<?php

namespace app\common\validators;

use app\common\classes\PostedFile;
use app\models\FileFormat;
use yii\validators\FileValidator;
use yii\web\UploadedFile;

class PostedFileValidator extends FileValidator
{
    /**
     * Message to inform that attribute isn't a array
     * @var string
     */
    public $notArray;

    /**
     * Will be transformed into string array of allowed extensions on init
     * @var FileFormat[]
     */
    public $allowedFormats;

    /**
     * With this you can set all validator params in one array
     * @var array
     */
    public $params;

    public function init()
    {
        parent::init();

        $this->maxFiles = 1;
        $this->maxSize = 20971520;

        if (!empty($this->params)) {
            foreach ($this->params as $paramName => $paramValue) {
                $this->$paramName = $paramValue;
            }
        }

        $extensions = [];
        if (isset($this->allowedFormats)) {
            foreach ($this->allowedFormats as $allowedFormat) {
                $extensions[] = $allowedFormat->extension;
            }
        }
        $filesAllowed = !empty($extensions);

        $this->extensions = $filesAllowed ? $extensions : '.';
        $this->wrongExtension = $filesAllowed ? null : 'File posting is not allowed on this board';
        $this->notArray = 'Attribute is not an array';

        print_r('MAX SIZE: ' . $this->maxSize . PHP_EOL);
    }

    public function validateAttribute($model, $attribute)
    {
        if (!is_array($model->$attribute)) {
            $this->addError($model, $attribute, $this->notArray);
            return;
        }

        /**
         * @var PostedFile[] $files
         */
        $files = $model->$attribute;

        foreach ($files as $i => $file) {
            if (!$file instanceof PostedFile) {
                unset($files[$i]);
            }
        }

        if (count($files) > $this->maxFiles) {
            $this->addError($model, $attribute, $this->tooMany, ['limit' => $this->maxFiles]);
        }

        foreach ($files as $file) {
            if ($file->fileData instanceof UploadedFile) {
                parent::validateValue($file);
            }
        }
    }
}