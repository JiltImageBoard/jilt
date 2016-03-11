<?php

namespace app\common\helpers;

class DataFormatter
{
    
    /**
     * @param array $objects
     * @return array
     */
    public static function mergeFieldsToObj($objects)
    {
        return self::toObject(array_reduce($objects, function($carry, $item) {
            return method_exists($item, 'toArray') ? $carry = array_merge($carry, $item->toArray()) : [];
        }, []));
    }


    /**
     * @param array $objects
     * @return array
     */
    public static function collectErrors($objects)
    {
        return array_reduce($objects, function($carry, $item) {
            return (isset($item->errors) && is_array($item->errors)) ?
                $carry += $item->errors : [];
        }, []);
    }

    /**
     * @param array $arr
     * @return \stdClass object
     */
    public static function toObject(array $arr)
    {
        $obj = new \stdClass();
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $val = self::toObject($val);
            }
            $obj->$key = $val;
        }

        return $obj;
    }
}