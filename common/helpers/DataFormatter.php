<?php

namespace app\common\helpers;

class DataFormatter
{
    /**
     * @param array $objects
     * @return array
     */
    public static function toArray($objects)
    {
        return self::toObject(array_reduce($objects, function($carry, $item){
            return method_exists($item, 'toArray') ? $carry = array_merge($carry, $item->toArray()) : [];
        }, []));
    }


    /**
     * @param array $objects
     * @return array
     */
    public static function errorsToArray($objects)
    {
        return self::toObject(array_reduce($objects, function($carry, $item){
            return !empty($item->errors) ? $carry = array_merge($carry, $item->errors) : [];
        }, []));
    }

    public static function toObject(Array $arr) {
        $obj = new \stdClass();
        foreach($arr as $key=>$val) {
            if (is_array($val)) {
                $val = self::toObject($val);
            }
            $obj->$key = $val;
        }

        return $obj;
    }
}