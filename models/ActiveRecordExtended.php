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
    /**
     * Associative array, where prop name can be binded with relation name, from model of which property will be taken
     * For example:
     * when $delegatedFields = ['board' => thread],
     * expression: $post->thread->board will be equal to $post->thread...nu i vot nahui ono nado lol..
     * This gives some advantage when if u want apply hereditary behaviour to model attributes
     * See FileInfo and it's descendants for real example
     * @var array
     */
    protected $delegatedFields = [];

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->relationDataArray = $this->initRelationDataArray();
    }

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
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (!$insert) return;

        $vars = get_object_vars($this);
        $relations = $this->relationDataArray;

        // extracting models from ids, set in props and linking them
        // props with ids should be equal to relation names
        foreach ($vars as $propName => $value) {
            foreach ($relations as $relation) {
                if ($propName == $relation->name) {
                    unset($this->$propName);
                    if (!empty($value)) {
                        $ModelClass = $relation->modelClass;
                        $ids = $value;
                        $models = $ModelClass::find()->where(['id' => $ids])->all();
                        foreach ($models as $model) $this->link($relation->name, $model);
                    }
                    break;
                }
            }
        }
    }


    /**
     * @param array|ErrorMessage $error|string
     * @param string|null $message
     * return void
     */
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
                /**
                 * @var ActiveRecordExtended $model
                 */
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
            if ($method->isStatic()) continue; //костыль?
            if (in_array($method->name, $ARMethods) || in_array($method->name, $modelMethods)) {
                continue;
            }

            if (StringHelper::startsWith($method->name, 'get')) {
                if ($method->name === 'getAttributesWithRelatedAsPost') continue;
                if ($method->name === 'getAttributesWithRelated') continue;

                try {
                    $rel = call_user_func(array($this, $method->name));
                    if ($rel instanceof ActiveQuery) {
                        $relationDataArray[] = new RelationData(
                            lcfirst(str_replace('get', '', $method->name)),
                            $method->name,
                            $rel->multiple,
                            $rel->modelClass,
                            $rel->link,
                            $rel->via
                        );
                    }
                } catch (ErrorException $exc) {
                    // TODO: implement some error output maybe?
                }
            }
        }

        return $relationDataArray;
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
