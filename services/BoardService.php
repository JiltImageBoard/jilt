<?php

namespace app\services;

use app\models\Board;
use app\models\Thread;
use yii\base\UserException;

class BoardService
{
    /**
     * @param  string   $boardName
     * @param  int      $pageNum
     * @param  int      $perPage
     * @return Thread[]
     * @throws UserException
     */
    public static function getThreadsPage(string $boardName, int $pageNum, int $perPage = 10)
    {
        /** @var Board $board */
        $board = Board::find()->where(['boards.name' => $boardName])->one();
        if (!$board) {
            throw new UserException('Board was not found', 404);
        }

        return $board->getThreads()->limit(10)->offset($pageNum * $perPage)->with(['postData', 'postData.fileInfos'])->all();
    }
}