<?php

namespace app\controllers;

use app\models\Board;
use app\models\BoardCounter;
use app\services\BoardService;
use yii\base\UserException;
use yii\web\Controller;
use yii\web\Response;

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
                // TODO: we need to return full entity, not just name 
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
     * @param $boardName
     * @param int $pageNum
     * @return mixed
     * @throws UserException
     */
    public function actionGetThreadsPage(string $boardName, int $pageNum = 0)
    {
        $board = Board::getByName($boardName);
        $threads = BoardService::getThreadsPage($board, $pageNum);

        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $threads;
        }

        return $this->render('threads-paged', ['threads' => $threads]);
    }

    /**
     * @param $name
     * @return array
     * @throws UserException
     */
    public function actionGet($name)
    {
        if ($board = Board::findOne(['name' => $name])) {
            return $board->toArray();
        }

        throw new UserException('Board was not found', 404);
    }

    /**
     * Updates board settings
     * @param $name
     * @return array|\yii\web\Response
     */
    public function actionUpdate($name)
    {
        $board = Board::findOne(['name' => $name]);
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