<?php

namespace app\controllers;

use app\common\classes\RelationData;
use app\models\Thread;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionRun($name = 'test')
    {
        echo '<pre>';
        $obj = new RelationData('asd', 'methodValue', 'asd', 'asd', 'asd', 'asd');
        $stdObj = new \stdClass();
        $stdObj->test = 'method';
        print_r($obj->{$stdObj->test});
        echo '</pre>';
    }
}