<?php

namespace app\controllers;

use app\models\Board;
use app\models\BoardSettings;
use app\models\FileFormat;
use yii\web\Controller;
use yii\base\Model;
use app\common\classes\MultiLoader;
use app\common\helpers\DataFormatter;

/**
 * Class BoardController
 * @package app\controllers
 */
class BoardController extends Controller
{

    /**
     * Creates board
     * @return array|\yii\web\Response
     */
    public function actionCreate()
    {
        //TODO: Check authorization.
        $board = new Board();
        $boardSettings = new BoardSettings();
        $models = [$board, $boardSettings];

        if (MultiLoader::load(\Yii::$app->request->post(), $models) && Model::validateMultiple($models)) {
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

    /**
     * Returns all exist boards
     * @return array
     */
    public function actionGetAll()
    {
        $boards = [];
        foreach (Board::find()->all() as $board) {
            $boards[] = [
                'name' => $board->name,
                'description' => $board->description
            ];
        }

        return $boards;
    }


    /**
     * Returns N threads from board
     * @param $name
     * @param int $threadNum
     * @return string
     */
    public function actionGetPage($name, $threadNum = 0)
    {
        $threadsRaw = Board::find()
            ->with('threads')
            ->where('boards.name = :boardName', [':boardName' => $name])
            ->one()
            ->threads;
        $threads = [];

        //TODO: Ограничить по максимальному количеству тредов на странице из настроек борды
        foreach ($threadsRaw as $thread) {
            $threads[] = [
                'boardName' => $thread->board->name,
                'number' => $thread->number,
                'isSticked' => $thread->isSticked,
                'isLocked' => $thread->isLocked,
                'isChat' => $thread->isChat,
                'isOpMarkEnabled' => $thread->isOpMarkEnabled,
                'name' => $thread->postData->name,
                'subject' => $thread->postData->subject,
                'message' => $thread->postData->message->text,
                'files' => [], //TODO: Реализовать файлы
                'isModPost' => $thread->postData->isModPost,
                'createdAt' => $thread->postData->createdAt,
                'updatedAt' => $thread->postData->updatedAt


            ];
        }
        return $threads;
    }

    /**
     * Gets board settings
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

    /**
     * Updates board settings
     * @param $name
     * @return string
     */
    public function actionUpdate($name)
    {
        $board = Board::find()->where(['name' => $name])->limit(1)->one();
        $boardSettings = $board->settings;
        $models = [$board, $boardSettings];

        if (MultiLoader::load(\Yii::$app->request->post(), $models) && Model::validateMultiple($models)) {
            if ($boardSettings->save()) {
                if ($board->save()) {
                    //return $this->redirect('boards');
                    return 'success';
                } else {
                    return $board->errors;
                }
            }
        }

    }

    /**
     * Deletes board
     * @param $name
     * @return string
     */
    public function actionDelete($name)
    {
        return 'board/delete' . $name;
    }



}