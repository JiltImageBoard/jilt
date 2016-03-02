<?php

namespace app\controllers;

use app\models\PostData;
use app\models\PostMessage;
use app\models\Thread;
use yii\web\Controller;
use yii\web\UploadedFile;

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

    /**
     * @param string $name
     */
    public function actionCreate($name)
    {
        // models involved: PostMessage, PostData, Thread
        $models = [new PostMessage(), new PostMessage(), new PostData(), new Thread()];
        $testData = new PostData();
        $testData->files = UploadedFile::getInstancesByName('files');
        //print_r(UploadedFile::getInstances())
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