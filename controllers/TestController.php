<?php

namespace app\controllers;

use app\models\Thread;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionRun($name = 'test')
    {
        $thread = new Thread();
        echo '<pre>';
        $thread->board;
        print_r($thread->className());
        echo '</pre>';
    }
}