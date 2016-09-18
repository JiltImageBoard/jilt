<?php

namespace app\models;
use app\common\classes\ErrorMessage;
use app\common\classes\RelationsManager;
use app\common\helpers\ArrayHelper;
use app\common\classes\RelationData;
use yii\base\ErrorException;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\common\helpers\StringHelper;

/**
 * Class ARExtended
 * @package app\models
 */
abstract class ARExtended extends ActiveRecord
{
    /**
     * Fields which will not be displayed through toArray() method
     * @var array
     */
    protected $hidden = [];

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function __get($key)
    {
        if ($key = $this->hasKey($key)) {
            return parent::__get($key);
        }
    }

    public function __set($key, $value)
    {
        if ($key = $this->hasKey($key)) {
            parent::__set($key, $value);
        }
    }

    public function __unset($key)
    {
        if ($key = $this->hasKey($key)){
            parent::__unset($key);
        }
    }

    public function hasKey($key)
    {
        if ($this->hasAttribute($key) || $this->hasProperty($key)) {
            return $key;
        } else {
            $key = StringHelper::camelCaseToUnderscore($key);
            if ($this->hasAttribute($key) || $this->hasProperty($key))
                return $key;
        }

        return null;
    }

    public function load($data, $formName = null)
    {
        $setAttributes = function (&$model, $data) {
            $loadResult = true;

            foreach ($data as $key => $value) {
                if ($model->hasKey($key)) {
                    $model->$key = $value;
                } elseif (in_array($key, $model->safeAttributes())) {
                    $model->$key = $value;
                } else {
                    $model->addError(ErrorMessage::UnknownModelKey($model->className(), $key));
                    $loadResult = false;
                }
            }

            return $loadResult;
        };

        $scope = $formName === null ? $this->formName() : $formName;

        if ($scope === '' && !empty($data)) {
            return $setAttributes($this, $data);
        } else if (isset($data[$scope])) {
            return $setAttributes($this, $data[$scope]);
        } else {
            return false;
        }
    }

    /**
     * @param array|ErrorMessage $error|string
     * @param string|null $message
     * return void
     */
    //TODO: Не позориться и сделать эксепшены
    public function addError($error, $message = null)
    {
        if ($message != null) {
            parent::addError($error, $message);
        } else {
            list($attribute, $error) = $error;
            parent::addError($attribute, $error);
        }
    }

    /**
     * @param array $fields
     * @param array $expand
     * @param bool|true $recursive
     * @return array
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        if (empty($fields)) {
            $fields = $this->fields();
        }

        $fields = array_diff($fields, $this->hidden);
        $data = parent::toArray(ArrayHelper::valuesToUnderscore($fields), $expand, $recursive);
        ArrayHelper::keysToCamelCase($data);

        return $data;
    }

    /**
     * Diff with Model::loadMultiple is, that we can pass models of different classes
     * @param Model[] $models
     * @param array $data
     * @return bool
     */
    public static function loadMultiple($models, $data, $formName = null)
    {
        $success = true;
        foreach ($models as $model) {
            $success = $success && $model->load($data);
        }

        return $success;
    }
}
