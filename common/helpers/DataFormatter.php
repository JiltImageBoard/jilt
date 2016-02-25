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
                $carry = array_merge($carry, $item->errors) : [];
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

    /**
     * Converting string from camel case to underscore
     * @param string $str
     * @return string
     */
    public static function camelCaseToUnderscore($str)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $str, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
    
}