<?php

namespace app\common\helpers;

class ArrayHelper
{
    
    public static function removeItems($array, ...$items)
    {
        return array_merge(array_diff($array, $items));
    }

    public static function getNumericSubset($array)
    {
        $result = [];
        foreach ($array as $item) {
            if (is_numeric($item)) {
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * @param $array
     * @return array
     */
    public static function keysToCamelCase($array)
    {
        foreach ($array as $key => $value) {
            $array[StringHelper::camelCaseToUnderscore($key)] = $value;
            unset($array[$key]);
        }

        return $array;
    }

    public static function valuesToUnderscore($array)
    {
        $output = [];
        foreach ($array as $value) {
            $output[] = StringHelper::camelCaseToUnderscore($value);
        }
        return $output;
    }
}