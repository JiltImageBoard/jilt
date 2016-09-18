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
    public static function getThreadsPage(Board $board, int $pageNum, int $perPage = 10)
    {
        return $board->getThreads()->limit(10)->offset($pageNum * $perPage)->with(['postData', 'postData.fileInfos'])->all();
    }
}