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
 * Class ActiveRecordExtended
 * @package app\models
 */
abstract class ActiveRecordExtended extends ActiveRecord
{
    /**
     * @var RelationData[]
     */
    public $relationDataArray = null;
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
        if ($key = $this->hasKey($key)){
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
        $loadResult = true;
        foreach ($data as $key => $value) {
            if ($this->hasKey($key)) {
                $this->$key = $value;
            } elseif(in_array($key, $this->safeAttributes())) {
                $this->$key = $value;
            } else {
                $this->addError(ErrorMessage::UnknownModelKey($this->className(),$key));
                $loadResult = false;
            }
        }

        return $loadResult;
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
    public static function loadMultiple($models, $data)
    {
        $success = true;
        foreach ($models as $model) {
            $success &= $model->load($data);
        }

        return $success;
    }

    public function getAfterSaveEvent()
    {
        return $this->isNewRecord ? static::EVENT_AFTER_INSERT : static::EVENT_AFTER_UPDATE;
    }

    /**
     * @param string $relationName
     * @param array|ActiveRecordExtended $models
     */
    public function linkAfterSave($relationName, $models)
    {
        $this->on($this->getAfterSaveEvent(), function() use ($relationName, &$models) {
            if (is_null($models)) {
                return;
            }

            if (!is_array($models)) {
                $this->link($relationName, $models);
                return;
            }

            foreach ($models as $model) {
                $this->link($relationName, $model);
            }
        });
    }

    /**
     * returns foreign key if model belongs to passed model
     *
     * @param ActiveRecordExtended $model
     * @return RelationData|null
     */
    public function belongsTo($model)
    {
        foreach ($this->relationDataArray as $relationData) {
            if ($relationData->modelClass === $model->className()) {
                $firstVal = reset($relationData->link);
                $foreignKey = $firstVal !== 'id' ? $firstVal : key($relationData->link);
                if ($this->hasAttribute($foreignKey))
                    return $foreignKey;
                return null;
            }
        }

        return null;
    }

    /**
     * TODO: make atomic
     * @param ActiveRecordExtended[] $models
     * @return bool
     */
    public static function saveAndLink($models)
    {
        return static::saveMultiple($models) && static::linkManyToMany($models);
    }

    /**
     * links all passed models by many to many relation when this is possible
     * @param ActiveRecordExtended[] $models
     * @return bool
     */
    public static function linkManyToMany($models)
    {
        for ($i = 0; $i < count($models) - 1; $i++) {
            for ($j = $i + 1; $j < count($models); $j++) {
                foreach ($models[$i]->relationDataArray as $relationDataItem) {
                    if (
                        $relationDataItem->modelClass == $models[$j]->className() &&
                        $relationDataItem->isMultiple === true
                    ) {
                        $models[$i]->link($relationDataItem->name, $models[$j]);
                        break;
                    }
                }
            }
        }

        return true;
    }

    /**
     * saves all passed models in correct order and links them by one to one/many relation.
     * e.g if $models[$i] requires id of $models[$i + 1], latter will be saved first and it's id will be inserted
     * to $models[$i]
     * @param ActiveRecordExtended[] $models
     * @return bool
     */
    public static function saveMultiple($models)
    {
        foreach ($models as $model)
            $model->saveOrdered($models);

        return true;
    }

    /**
     * @param ActiveRecordExtended[] $models
     * @return bool
     */
    public function saveOrdered($models)
    {
        if (!$this->isNewRecord) return true;

        foreach ($models as $model) {
            if ($model === $this || !$this->isNewRecord) continue;

            if (!is_null($foreignKey = $this->belongsTo($model))) {
                if (!$model->saveOrdered($models))
                    return false;
                $this->$foreignKey = $model->id;
            }
        }

        return $this->save();
    }
}
