<?php

namespace app\controllers;

use app\models\Board;
use yii\web\Controller;

class TestController extends Controller
{

    /**
     * @param string $boardName имя борды
     * @param int $pageNum
     */
    public function actionRun($boardName = 'test', $pageNum = 1)
    {
        $threadsRaw = Board::find()
            ->where('boards.name = :boardName', [':boardName' => $boardName])
            ->one()
            ->threads;

        $threads = [];

        foreach ($threadsRaw as $thread){
            $threads[] =
        }
    }
}