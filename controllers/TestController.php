<?php

namespace app\controllers;

use app\models\Thread;
use app\models\User;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionRun($name = 'test')
    {
//        $session = \yii::$app->session;
//        $session->open();
//        return $session->get('username');
        $user = new User();
        $obj = $user->find()->where('username = :username', [':username' => 'desu'])->one();
        return $obj->username;
    }
}