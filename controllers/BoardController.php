<?php

namespace app\controllers;

use app\models\Board;
use app\models\BoardSetting;
use yii\web\Controller;
use yii\base\Model;
use app\common\classes\MultiLoad;
use app\common\helpers\DataFormatter;

class BoardController extends Controller
{

    public function actionCreate()
    {
        $models = [new Board(), new BoardSetting()];

        MultiLoad::load(\Yii::$app->request->post(), $models);

        if (Model::validateMultiple($models)) {
            return DataFormatter::toArray($models);
        } else {
            return DataFormatter::errorsToArray($models);
        }
    }

    public function actionGetAll()
    {
        $boards = [];
        foreach (Board::find()->all() as $board)
            $boards[] = [$board->name, $board->settings->description];

        return $boards;
    }

    public function actionGetPage($name, $pageNum)
    {
        $board = Board::find()->where(['name' => $name])->limit(1)->one();
        return "asdas";
    }

    public function actionGet($name)
    {
        return 'board/get/' . $name;
    }

    public function actionUpdate($name)
    {
        return 'board/update/' . $name;
    }

    public function actionDelete($name)
    {
        return 'board/delete' . $name;
    }



}