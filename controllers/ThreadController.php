<?php

namespace app\controllers;

use yii\web\Controller;

class ThreadController extends Controller
{

    /**
     * @param string $name
     * @param int $threadNum
     * @return int
     */
    public function actionGet($name, $threadNum = 1)
    {
        return $threadNum;
    }

    public function actionCreate()
    {

    }

    /**
     * @param string $name
     * @param int $threadNum
     */
    public function update($name, $threadNum)
    {

    }

    /**
     * @param string $name
     * @param int $threadNum
     */
    public function delete($name, $threadNum)
    {

    }
}