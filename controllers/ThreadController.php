<?php

namespace app\controllers;

use yii\web\Controller;

class ThreadController extends Controller
{
    
    public function actionGet($name, $threadNum = 1)
    {
        return $threadNum;
    }

}