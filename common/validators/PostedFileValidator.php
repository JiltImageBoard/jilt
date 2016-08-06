<?php

namespace app\common\validators;

use app\common\classes\PostedFile;
use app\models\MimeType;
use app\models\FileInfo;
use app\models\PostsSettings;
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

    /** @var  array */
    public $params;

    public function init()
    {
        parent::init();

        $this->maxFiles = 1;
        $this->maxSize = 20971520;

        if (!empty($this->array)) {
            foreach ($this->array as $prop => $value) {
                $this->$prop = $value;
            }
        }

        // turning mime types into strings
        foreach ($this->mimeTypes as $i => $mimeType) {
            if ($mimeType instanceof MimeType) {
                $this->mimeTypes[$i] = $mimeType->name;
            }
        }
        $filesAllowed = !empty($this->mimeTypes);
        $this->mimeTypes = $filesAllowed ? $this->mimeTypes : ['.'];

        /*
         * We placing dot if there is no mimeTypes because for yii FileValidator "no mime types" means
         * that all types is allowed, which is not what we want
         */
        if (!$filesAllowed) {
            $this->wrongExtension = 'File posting is not allowed on this board';
        }
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
            $result = $this->validateValue($file);

            if (!empty($result)) {
                $this->addError($model, $attribute, $result[0], $result[1]);
            }
        }
    }

    public function isEmpty($value, $trim = false)
    {
        if (!is_array($value)) {
            return !($value instanceof PostedFile);
        }

        foreach ($value as $item) {
            if ($item instanceof PostedFile) {
                return false;
            }
        }

        return true;
    }

    protected function validateValue($value)
    {
        if (!$value instanceof PostedFile) {
            throw new \InvalidArgumentException();
        }

        if (!empty($value->uploadedFile)) {
            return self::validateUploadedFile($value->uploadedFile);
        }

        return self::validateFileInfo($value->fileInfo);
    }

    protected function validateUploadedFile(UploadedFile $file) {
        $baseValidation = parent::validateValue($file);
        if (!empty($baseValidation)) {
            return $baseValidation;
        }
    }

    protected function validateFileInfo(FileInfo $file) {
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