<?php

namespace app\controllers;

use app\common\classes\MultiLoader;
use app\common\filters\BanFilter;
use app\common\helpers\DataFormatter;
use app\models\ActiveRecordExtended;
use app\models\Board;
use app\models\Post;
use app\models\PostData;
use app\models\PostMessage;
use app\models\Thread;
use yii\base\Model;
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
        return 'Not implemented';
    }
    
    public function actionGetPage($name, $threadNum, $pageNum)
    {
        return 'Not implemented';
    }

    /**
     * @param string $name
     * @return array|string
     */
    public function actionCreate($name)
    {
        /**
         * @var Board $board
         */
        if ($board = Board::findOne(['name' => $name])) {
            $thread = new Thread(['boardId' => $board->id]);
            $models = [
                $thread,
                new PostMessage(),
                new PostData([
                    //TODO: Мы не можем полагаться лишь на один массив файлов,
                    // потому что в таком случае порушиться последовательность их загрузки, так как стандарт этого не гарантирует
                    'files' => UploadedFile::getInstancesByName('files'),
                    'allowedFormats' => $board->fileFormats
                ])
            ];
            
            if (
                ActiveRecordExtended::loadMultiple(\Yii::$app->request->post(), $models) &&
                Model::validateMultiple($models)
            ) {
                if (ActiveRecordExtended::saveAndLink($models)) {
                    return $thread->toArray();
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
     * @return string
     */
    public function actionUpdate($name, $threadNum)
    {
        return 'Not implemented';
    }

    /**
     * @param string $name
     * @param int $threadNum
     * @return string
     */
    public function actionDelete($name, $threadNum)
    {
        return 'Not implemented';
    }

    public function behaviors()
    {
        return [
            [
                'class' => BanFilter::className()
            ]
        ];
    }
}