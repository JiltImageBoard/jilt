<?php

namespace app\common\classes;

class MultiLoader {

    /**
     * Load data into models
     * @param array $data can be any associative array
     * @param array $models Array with model objects
     * @return bool
     */
    public static function load($data, $models)
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
                return false;
            }
        }
        return true;
    }

}