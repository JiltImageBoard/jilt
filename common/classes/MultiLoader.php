<?php

namespace app\common\classes;

class MultiLoader {

    /**
     * Loads data into models
     * @param array $data can be any associative array, each array item should be loaded into some model
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
                print_r($data);
                return false;
            }
        }
        return true;
    }

}