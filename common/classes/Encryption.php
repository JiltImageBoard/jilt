<?php

namespace app\common\classes;


class Encryption
{
    /**
     * This method is insecure to generate passwords
     * random_bytes() added in PHP7, but jilt doesn't fully supports PHP 7
     * return string
     */
    public static function getRandomString()
    {
        return str_shuffle(md5(uniqid(mt_rand(), true)));
    }
    
    public static function hashPassword($str)
    {
        return hash('sha512', $str);
    }
}