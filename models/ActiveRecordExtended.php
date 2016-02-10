<?php

namespace app\models;
use yii\db\ActiveRecord;
use app\common\helpers\DataFormatter;

/**
 * Class ActiveRecordExtended
 * @package app\models
 */
class ActiveRecordExtended extends ActiveRecord
{
    /**
     * @var array[]
     */
    protected $lazyRelations;

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
            $key = DataFormatter::camelCaseToUnderscore($key);
            if ($this->hasAttribute($key) || $this->hasProperty($key))
                return $key;
        }

        return null;
    }

    protected function addLazyRelation($modelName, $relationName, $relatedIds)
    {
        if (isset($this->lazyRelations[$modelName])) {
            $this->lazyRelations[$modelName]['ids'] = array_merge($this->lazyRelations[$modelName], $relatedIds);
        }
        else {
            $this->lazyRelations[$modelName]['ids'] = $relatedIds;
            $this->lazyRelations[$modelName]['relationName'] = $relationName;
        }
    }
}