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
}