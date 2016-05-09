<?php

namespace app\common\validators;

use app\common\classes\PostedFile;
use app\models\MimeType;
use app\models\FileInfo;
use Yii;
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
     * @var MimeType[]
     */
    public $allowedMimeTypes;

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

        $mimeTypes = [];
        if (isset($this->allowedMimeTypes)) {
            foreach ($this->allowedMimeTypes as $allowedMimeType) {
                $mimeTypes[] = $allowedMimeType->name;
            }
        }
        $filesAllowed = !empty($mimeTypes);

        /*
         * We placing dot if there is no mimeTypes because for yii FileValidator "no mime types" means
         * that all types is allowed, which is not what we want
         */
        if (!$filesAllowed) {
            $this->wrongExtension = 'File posting is not allowed on this board';
        }
        $this->mimeTypes = $filesAllowed ? $mimeTypes : ['.'];
        $this->notArray = 'Attribute is not an array';
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

        foreach ($files as $file) {
            if ($file->fileData instanceof UploadedFile) {
                $result = parent::validateValue($file->fileData);
            } elseif ($file->fileData instanceof FileInfo) {
                $result = $this->validateValue($file->fileData);
            }

            if (!empty($result)) {
                $this->addError($model, $attribute, $result[0], $result[1]);
            }
        }
    }

    public function isEmpty($value, $trim = false)
    {
        if (!is_array($value)) {
            return !$value instanceof PostedFile;
        }

        foreach ($value as $item) {
            if ($item instanceof PostedFile) {
                return false;
            }
        }

        return true;
    }

    protected function validateValue(FileInfo $file)
    {
        $fileType = $file->mimeType->name;

        if (!in_array($fileType, $this->mimeTypes)) {
            return [
                $this->wrongMimeType,
                ['file' => $file->originalName, 'mimeTypes' => implode(', ', $this->mimeTypes)]
            ];
        }

        if ($file->size > $this->getSizeLimit()) {
            return [
                $this->tooBig,
                [
                    'file' => $file->originalName,
                    'limit' => $this->getSizeLimit(),
                    'formattedLimit' => Yii::$app->formatter->asShortSize($this->getSizeLimit())
                ]
            ];
        }

    }
}