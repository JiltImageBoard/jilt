<?php

namespace app\common\helpers;

class StringHelper
{
    /**
     * Converts string from camelCase style to under_score
     * @param string $str
     * @return string
     */
    public static function camelCaseToUnderscore($str)
    {
        return ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $str)), '_');
    }

    /**
     * Converting string from under_score style to camelCase
     * @param string $str
     * @return string
     */
    public static function underscoreToCamelCase($str)
    {
        return str_replace('_', '', lcfirst(ucwords($str, '_')));
    }
}