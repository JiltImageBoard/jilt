<?php

namespace app\controllers;

use yii\web\Controller;

class ErrorController extends Controller
{

    public function actionNotFound()
    {
        return '404 not found';
    }
}