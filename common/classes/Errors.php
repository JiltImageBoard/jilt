<?php

namespace app\common\classes;


class Errors
{

    public static function ModelNotFound($modelName, $id)
    {
        return [$modelName, 'Model with id ' . $id . ' was not found.'];
    }
    
    public static function UnknownModelKey($modelName, $key)
    {
        return [$modelName, 'Unknown model key ' . $key . '.'];
    }
    
    public static function ClassNotFound($class)
    {
        return [$class, 'Class ' . $class . 'not found.'];
    }
    
    public static function ModelLinkingError()
    {
        return ['Model linking error', 'Not all models was found'];
    }
}