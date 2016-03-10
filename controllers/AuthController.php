<?php

namespace app\controllers;

use app\common\helpers\ArrayHelper;
use app\models\Board;
use app\models\BoardCounter;
use yii\web\Controller;

class AuthController extends Controller
{

    public function actionLogin()
    {
        return \yii::$app->params['salt'];
    }

    public function actionLogout()
    {

    }

    public function actionResetPassword()
    {

    }
}