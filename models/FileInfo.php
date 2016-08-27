<?php

namespace app\models;

use yii\base\ErrorException;
use yii\web\UploadedFile;

/**
 * Class FileInfo
 * @package app\models
 * @property int $id
 * @property int $mimeTypesId
 * @property string $filePath
 * @property string $originalName
 * @property string $hash
 * @property float $size
 * @property ARExtended $subClassInstance
 * relations
 * @property MimeType $mimeType
 */
class FileInfo extends ARExtended
{
    public static function tableName()
    {
        return 'files_info';
    }

    public function getMimeType()
    {
        return $this->hasOne(MimeType::className(), ['id' => 'mime_type_id']);
    }

    /**
     * @return ARExtended|null
     */
    public function getSubClassName()
    {
        if (is_null($this->mimeType)) {
            return null;
        }

        $className = 'app\models\File' . ucfirst(explode('/', $this->mimeType->name)[0]);
        return class_exists($className) ? $className : null;
    }

    /**
     * @return ARExtended|null
     */
    public function getSubClassInstance()
    {
        $SubClass = $this->getSubClassName();
        if (is_null($SubClass)) {
            return null;
        }

        return $SubClass::findOne(['files_info_id' => $this->id]);
    }

    public function beforeDelete()
    {
        $subClassInstance = $this->getSubClassInstance();
        if (!is_null($subClassInstance)) {
            print_r('deleting subclass instance' . PHP_EOL);
            $subClassInstance->delete();
        } else {
            print_r('subclass instance was not found' . PHP_EOL);
        }

        unlink($this->filePath);

        return true;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $isFilePathChanged = $this->getOldAttribute('file_path') !== $this->filePath;

        if (!parent::save($runValidation, $attributeNames)) {
            return false;
        }

        if (!$isFilePathChanged) {
            return true;
        }

        $subClassInstance = $this->getSubClassInstance();
        if (!is_null($subClassInstance)) {
            $subClassInstance->delete();
        }

        $SubClass = $this->getSubClassName();
        if (is_null($SubClass)) {
            parent::delete();
            throw new ErrorException('File subclass was not found');
            return false;
        }

        $subClassInstance = new $SubClass(['filesInfoId' => $this->id]);
        if ($subClassInstance->save()) {
            $subClassInstance->link('fileInfo', $this);
        } else {
            print_r('subclass instance was not saved\n');
            parent::delete();
            return false;
        }

        return true;
    }
}
