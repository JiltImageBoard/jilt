<?php

namespace app\controllers;

use app\common\classes\MultiLoader;
use app\common\helpers\DataFormatter;
use app\models\ActiveRecordExtended;
use app\models\Board;
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
        if ($board = Board::find()->where(['name' => $name])->limit(1)->one()) {
            $postData = new PostData();
            $thread = new Thread();
            $postData->filesToUpload = UploadedFile::getInstancesByName('files');
            $thread->boardId = $board->id;
            
            $models = [&$thread, new PostMessage(), &$postData];
            
            if (
                ActiveRecordExtended::loadMultiple(\Yii::$app->request->post(), $models) &&
                Model::validateMultiple($models)
            ) {
                if (ActiveRecordExtended::saveAndLink($models)) {
                    //TODO: return thread presented like from ->toArray() method (don't work now)
                    return 'yayyy(ne yay)';
                }
            }

            return DataFormatter::collectErrors($models);
        }

        \Yii::$app->response->setStatusCode(404);
        return 'Board was not found';
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