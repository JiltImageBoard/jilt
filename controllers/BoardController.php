<?php

namespace app\controllers;

use app\models\Board;
use app\models\BoardSettings;
use app\models\FileFormat;
use yii\web\Controller;
use yii\base\Model;
use app\common\classes\MultiLoader;
use app\common\helpers\DataFormatter;

class BoardController extends Controller
{

    public function actionCreate()
    {
        //TODO: Check authorization.
        $board = new Board();
        $boardSettings = new BoardSettings();
        $models = [$board, $boardSettings];

        if (MultiLoader::load(\Yii::$app->request->post(), $models) /*&& Model::validateMultiple($models)*/) {
            if ($boardSettings->save()) {
                $board->settingsId = $boardSettings->id;
                if ($board->save()) {
                    return $this->redirect('boards');
                    //TODO: Разобраться почему со статус кодом 201 не отправляются борды. Возможно придется использовать $this->actionGetAll(true)
                }
            }
        }

        return DataFormatter::collectErrors($models);
    }

    public function actionGetAll()
    {
        $boards = [];
        foreach (Board::find()->all() as $board) {
            $boards[] = [
                'name' => $board->name,
                'description' => $board->settings->description
            ];
        }

        return $boards;
    }


    public function actionGetPage($name, $pageNum = 0)
    {
        //TODO: Для этого метода нужно реализовать треды
    }

    /** Gets board settings
     * @param $name
     * @return array
     */
    public function actionGet($name)
    {
        $board = Board::find()->where(['name' => $name])->limit(1)->one();
        if (!empty($board->settings)) {
            return $board->settings;
        }
        //TODO: Оформить ошибку
        return 'error';
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