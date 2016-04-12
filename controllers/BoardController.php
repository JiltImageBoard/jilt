<?php

namespace app\controllers;

use app\models\Board;
use app\models\BoardCounter;
use yii\web\Controller;

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

        if ($board->load(\Yii::$app->request->post()) && $board->validate()) {
            if ($board->save()) {
                $boardCounter = new BoardCounter();
                $boardCounter->boardId = $board->id;
                $boardCounter->save();
                \Yii::$app->response->setStatusCode(201);
                return $this->actionGet($board->name);
            }
        }
        
        return $board->errors;
    }

    /**
     * Returns all exist boards
     * @return array|\yii\web\Response
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
     * @param int $pageNum
     * @return array|\yii\web\Response|bool
     */
    public function actionGetPage($name, $pageNum = 0)
    {
        $board = Board::find()
            ->joinWith([
                'threads' => function ($query) {
                    $query->orderBy('updated_at');
                },
                'threads.postData'
            ])
            ->where(['boards.name' => $name])
            ->one();
        if ($board) {
            $threadsJson = [];

            // TODO: pagination not implemented
            foreach ($board->threads as $thread) {
                $threadsJson[] = [
                    'boardName' => $thread->board->name,
                    'number' => $thread->number,
                    'isSticked' => $thread->isSticked,
                    'isLocked' => $thread->isLocked,
                    'isChat' => $thread->isChat,
                    'isOpMarkEnabled' => $thread->isOpMarkEnabled,
                    'name' => $thread->postData->name,
                    'subject' => $thread->postData->subject,
                    'message' => $thread->postData->postMessage->text,
                    'files' => [], //TODO: Реализовать файлы
                    'isModPost' => $thread->postData->isModPost,
                    'createdAt' => $thread->postData->createdAt,
                    'updatedAt' => $thread->postData->updatedAt
                ];
            }
            return $threadsJson;
        }

        return null;
    }

    /**
     * Gets board info
     * @param $name
     * @return array|\yii\web\Response
     */
    public function actionGet($name)
    {
        if ($board = Board::find()->where(['name' => $name])->limit(1)->one()) {
                return $board->toArray(['id', 'counter']);
        }

        \Yii::$app->response->setStatusCode(404);
        //TODO: Нормальная ошибка
        return 'Board was not found';
    }

    /**
     * Updates board settings
     * @param $name
     * @return array|\yii\web\Response
     */
    public function actionUpdate($name)
    {
        $board = Board::find()->where(['name' => $name])->limit(1)->one();

        if ($board->load(\Yii::$app->request->post()) && $board->validate()) {
            if ($board->save()) {
                return $this->actionGet($board->name);
            }
        }

        return $board->errors;
    }

    /**
     * Deletes board
     * @param $name
     */
    public function actionDelete($name)
    {
        $board = Board::find()->where(['name' => $name])->limit(1)->one();

        if ($board) {
            $board->isDeleted = true;
            $board->save();
        }
        \Yii::$app->response->setStatusCode(204);
    }
}