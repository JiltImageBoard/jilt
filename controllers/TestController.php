<?php

namespace app\controllers;

use app\models\BoardSetting;
use app\models\Board;
use yii\web\Controller;
use app\common\helpers\DataFormatter;

class TestController extends Controller
{
    public function actionRun()
    {
        $board = new Board();
        $board->name = '1123';
        $boardSettings = new BoardSetting();
        $boardSettings->description = 'asdasd';

        print_r(DataFormatter::toArray($board, $boardSettings));
    }
}