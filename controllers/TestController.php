<?php

namespace app\controllers;

use app\common\classes\RelationData;
use app\models\Board;
use app\models\Thread;
use app\common\helpers\StringHelper;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionRun($name = 'test')
    {
        echo '<pre>';
        $str = 'under_scored_val';
        print_r(Board::find()->one()->toArray());
        echo '</pre>';
    }
}