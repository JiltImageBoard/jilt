<?php

namespace app\models;
use app\common\helpers\ArrayHelper;
use app\common\classes\RelationData;
use yii\base\Exception;
use yii\db\ActiveRecord;
use app\common\helpers\DataFormatter;
use app\common\helpers\StringHelper;

/**
 * Class ActiveRecordExtended
 * @package app\models
 */
class ActiveRecordExtended extends ActiveRecord
{
    /**
     * @var RelationData[] $relationDataArray
     */
    protected $relationDataArray = null;
    protected $delegatedFields = [];

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->relationDataArray = $this->initRelationDataArray();
    }


    /**
     * @var array[]
     */
    protected $lazyRelations = [];

    public function __get($key)
    {
        $this->accessDelegatedField($key, function ($field) use (&$delegatedField) {
            $delegatedField = $field;
        });

        if (isset($delegatedField))
            return $delegatedField;

        if ($key = $this->hasKey($key)){
            return parent::__get($key);
        }
    }

    public function __set($key, $value)
    {
        $this->accessDelegatedField($key, function (&$field) use ($value, &$isDelegated) {
            $field = $value;
        });

        if (isset($isDelegated)) return;

        if ($key = $this->hasKey($key)) {
            parent::__set($key, $value);
        }
    }

    public function __unset($key)
    {
        $this->accessDelegatedField($key, function () use (&$isDelegated) {
            return false;
        });

        if (isset($isDelegated)) return;

        if ($key = $this->hasKey($key)){
            parent::__unset($key);
        }
    }

    public function hasKey($key)
    {
        $this->accessDelegatedField($key, function () use (&$isDelegated) {});

        if (isset($isDelegated)) return $key;

        if ($this->hasAttribute($key) || $this->hasProperty($key)) {
            return $key;
        } else {
            $key = StringHelper::camelCaseToUnderscore($key);
            if ($this->hasAttribute($key) || $this->hasProperty($key))
                return $key;
        }

        return null;
    }

    protected function addLazyRelation($modelName, $relationName, $relatedIds)
    {
        $relatedIds = ArrayHelper::getNumericSubset($relatedIds);

        if (isset($this->lazyRelations[$modelName])) {
            $this->lazyRelations[$modelName]['ids'] = array_merge($this->lazyRelations[$modelName], $relatedIds);
        } else {
            $this->lazyRelations[$modelName]['ids'] = $relatedIds;
            $this->lazyRelations[$modelName]['relationName'] = $relationName;
        }
    }

    public function load($data, $formName = null)
    {
        $loadResult = true;
        foreach ($data as $key => $value) {
            if ($this->hasKey($key)) {
                $this->$key = $value;
            } else {
                $this->addError($key, 'Unknown model key');
                $loadResult = false;
            }
        }

        return $loadResult;
    }

    /**
     * Loads data into models
     * @param array $data can be any associative array, each array item should be loaded into some model
     * @param array $models Array with model objects
     * @return bool
     */
    public static function loadMultiple($data, $models)
    {
        foreach ($data as $key => $value) {
            $keyValueLoaded = false;
            foreach ($models as $model) {
                if ($model->hasKey($key)) {
                    $model->$key = $value;
                    $keyValueLoaded = true;
                    break;
                }
            }

            if (!$keyValueLoaded) {
                print_r($data);
                return false;
            }
        }
        return true;
    }

    /**
     * Links related models specified in lazyRelations array by many-to-many relation type
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $lazyRelationCheck = true;
        $relatedModels = [];

        foreach ($this->lazyRelations as $modelClass => $relationInfo) {
            if (!$lazyRelationCheck) break;

            if (class_exists($modelClass)) {
                $relationName = $relationInfo['relationName'];
                $ids = $relationInfo['ids'];

                /**
                 * @var ActiveRecord[] $models
                 */
                $models = $modelClass::find()->where(['id' => $ids])->all();
                $existingModelIds = [];
                foreach ($models as $model) {
                    if ($model) {
                        $relatedModels[$relationName][] = $model;
                        array_push($existingModelIds, $model->getPrimaryKey());
                    }
                }

                $invalidIds = array_diff($ids, $existingModelIds);
                foreach ($invalidIds as $id) {
                    $this->addError($relationName, 'Model with id ' . $id . ' was not found');
                    $lazyRelationCheck = false;
                }
            } else {
                $this->addError($modelClass, 'Class was not found');
                $lazyRelationCheck = false;
                break;
            }
        }

        if ($lazyRelationCheck) {
            if (parent::save($runValidation, $attributeNames)) {
                foreach ($relatedModels as $relationName => $models) {
                    foreach ($models as $model) {
                        $this->link($relationName, $model);
                    }
                }
                return true;
            }
        }

        $this->addError('Model linking error', 'Not all models was found');
        return false;
    }

    /**
     * Gets all relations with this model
     * TODO: should be reworked. Calls methods for retrieve return type, it's not optimal
     * @return array
     */
    public function initRelationDataArray()
    {
        $ARMethods = get_class_methods('\yii\db\ActiveRecord');
        $modelMethods = get_class_methods('\yii\base\Model');
        $reflection = new \ReflectionClass($this);
        $relationDataArray = [];
        /* @var $method \ReflectionMethod */
        foreach ($reflection->getMethods() as $method) {
            if (in_array($method->name, $ARMethods) || in_array($method->name, $modelMethods)) {
                continue;
            }
            if ($method->name === 'bindModels') {
                continue;
            }
            if ($method->name === 'attachBehaviorInternal') {
                continue;
            }
            if ($method->name === 'loadAll') {
                continue;
            }
            if ($method->name === 'saveAll') {
                continue;
            }
            if ($method->name === 'initRelationDataArray') {
                continue;
            }
            if ($method->name === 'getAttributesWithRelatedAsPost') {
                continue;
            }
            if ($method->name === 'getAttributesWithRelated') {
                continue;
            }
            if ($method->name === 'deleteWithRelated') {
                continue;
            }
            try {
                $rel = call_user_func(array($this, $method->name));
                if ($rel instanceof \yii\db\ActiveQuery) {
                    $relationDataArray[] = new RelationData(
                        lcfirst(str_replace('get', '', $method->name)),
                        $method->name,
                        $rel->multiple,
                        $rel->modelClass,
                        $rel->link,
                        $rel->via
                    );
                }
            } catch (\yii\base\ErrorException $exc) {
                // TODO: implement some error output maybe?
            }
        }

        return $relationDataArray;
    }


    /**
     * Returns all model fields and relations id's. 
     * @param array $fieldsToUnset Fields which shouldn't be printed
     * @return array
     */
    public function toArray(...$fieldsToUnset)
    {
        $attributes = $this->attributes;

        unset($attributes['id']);
        foreach ($attributes as $key => $value) {
            $data[StringHelper::underscoreToCamelCase($key)] = $value;
        }

        foreach ($this->relationDataArray as $relationData) {
            if ($relationData->isMultiple) {
                foreach ($this->{$relationData->name} as $relationModel) {
                    $data[$relationData->name][] = $relationModel['id'];
                }
            } else {
                $data[$relationData->name] = $this->{$relationData->name}->id;
            }
            
            
        }
        
        foreach ($fieldsToUnset as $field) {
            if (array_key_exists($field, $data)) {
                unset($data[$field]);
            }
        }
        return $data;
    }

    /**
     * Accesses delegated to some relation field and if it there is such relation with field $key,
     * Callback will be invoked. Field will be unsetted if callback returns false
     * @param string $key
     * @param $callback
     */
    private function accessDelegatedField($key, $callback)
    {
        if (isset($this->delegatedFields[$key])) {
            $relationName = $this->delegatedFields[$key];
            $relationModel = $this->$relationName;
            if (isset($relationModel)) {
                if ($relationModel->hasKey($key)) {
                    if ($callback($relationModel[$key]) === false)
                        unset($relationModel[$key]);
                }
            }
        }
    }

    /**
     * TODO: make atomic
     * @param ActiveRecordExtended[] $models
     * @return bool
     */
    public static function saveAndLink($models) {
        foreach ($models as $model) {
            if (!$model->save()) return false;
        }

        for ($i = 0; i < count($models) - 1; $i++) {
            for ($j = $i + 1; $j < count($models); $j++) {
                foreach ($models[i]->relationDataArray as $relationDataItem) {
                    if ($relationDataItem->modelClass == $models[j]->className()) {
                        $models[i]->link($relationDataItem->name, $models[j]);
                        break;
                    }
                }
            }
        }

        return true;
    }
}