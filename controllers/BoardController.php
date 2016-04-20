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
        $board->scenario = Board::SCENARIO_CREATE;
        if ($board->load(\Yii::$app->request->post()) && $board->validate()) {
            if ($board->save()) {
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
        /** @var Board $board */
        foreach (Board::find()->all() as $board) {
            $boards[] = [
                'id'  => $board->id,
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
        /** @var Board $board */
        $board = Board::find()
            ->where(['boards.name' => $name])
            ->one();
        if ($board) {
            $threadsJson = [];

            // TODO: pagination not implemented
            foreach ($board->threads as $thread) {
                $threadsJson[] = [
                    'id' => $thread->id,
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
                    'updatedAt' => $thread->updatedAt
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
        if ($board = Board::findOne(['name' => $name])) {
            return $board->toArray();
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
        $board->scenario = Board::SCENARIO_UPDATE;
        
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