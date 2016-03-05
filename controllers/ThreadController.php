<?php

namespace app\controllers;

use app\common\classes\MultiLoader;
use app\common\helpers\DataFormatter;
use app\models\ActiveRecordExtended;
use app\models\Post;
use app\models\PostData;
use app\models\PostMessage;
use app\models\Thread;
use yii\base\Model;
use yii\helpers\Json;
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
     * @return array|string
     */
    public function actionCreate($name)
    {
        // models involved: PostMessage, PostData, Thread
        $postData = new PostData();
        $models = [new PostMessage(), &$postData, new Thread()];
        if (
            ActiveRecordExtended::loadMultiple(\Yii::$app->request->post(), $models) &&
            Model::validateMultiple($models)
        ) {
            $postData->filesToUpload = UploadedFile::getInstancesByName('files');
            if (ActiveRecordExtended::saveAndLink($models)) {
                return 'yayyy';
            }
        }

        return DataFormatter::collectErrors($models);
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