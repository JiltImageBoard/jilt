<?php

namespace app\common\classes;

class MultiLoad {

    /**
     * Load data into models
     * @param array $data can be any associative array
     * @param array $models Array with model objects
     * @return void
     */
    public static function load($data, $models)
    {
        foreach ($data as $key => $value) {
            foreach ($models as $model) {
                if ($model->hasAttribute($key)) {
                    $model->$key = $value;
                    break;
                }
            }
        }
    }

}