<?php

namespace app\common\classes;


class Encryption
{
    /**
     * return string
     */
    public static function getRandomString()
    {
        return \Yii::$app->security->generateRandomString();
    }

    /**
     * @param $str
     * @return string
     */
    public static function hashPassword($str)
    {
        return hash('sha512', $str);
    }

    /**
     * @param \app\models\User $user
     * @return string
     */
    public static function getCsrfToken($user)
    {
        $session = \yii::$app->session;
        $session->open();

        return hash('sha512', \yii::$app->params['salt'] . $session->id . $user->salt);
    }
}