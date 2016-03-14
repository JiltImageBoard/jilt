<?php

namespace app\controllers;

use app\common\classes\RelationData;
use app\models\Board;
use app\models\Thread;
use app\common\helpers\StringHelper;
use yii\base\Object;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionRun($name = 'test')
    {
        echo '<pre>';
        echo '</pre>';
    }
}

class TestClass
{
    public static function test()
    {
        print_r("asdsadsa");
    }
}