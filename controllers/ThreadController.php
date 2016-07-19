<?php

namespace app\controllers;

use app\common\classes\PostedFile;
use app\common\classes\MultiLoader;
use app\common\filters\BanFilter;
use app\common\helpers\DataFormatter;
use app\models\ARExtended;
use app\models\Board;
use app\models\Post;
use app\models\PostData;
use app\models\PostMessage;
use app\models\Thread;
use app\models\UploadForm;
use Faker\Provider\File;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use Yii;

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
        
        $data = Yii::$app->request->post();

        if (!$board = Board::findOne(['name' => $name])) {
            Yii::$app->response->setStatusCode(404);
            return 'Board was not found';
        }
        
        $settings = $board->postsSettings;

        $thread     = new Thread(['boardId' => $board->id]);
        $postData   = new PostData(['settings' => $settings]);
        $uploadForm = new UploadForm([
            'files'    => PostedFile::getPostedFiles($settings->maxFiles),
            'settings' => $settings
        ]);

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $toLoad = [$thread, $postData];
            $toValidate = [$thread, $postData, $uploadForm];
            $toSave = [$thread, $postData, $uploadForm];

            if (!ARExtended::loadMultiple($toLoad, $data) || Model::validateMultiple($toValidate)) {
                return ['success' => false];
            }

            $saved = true;
            foreach ($toSave as $item) {
                if (method_exists($item, 'save')) {
                    $saved = $saved && $item->save();
                }
            }

            if (!$saved) {
                return ['success' => false];
            }

            foreach ($uploadForm->getFileInfos() as $fileInfo) {
                $postData->link('fileInfos', $fileInfo);
            }
            $thread->link('postData', $postData);

            return ['success' => true];
        }

        return $this->render('create', [
            'thread'      => $thread,
            'postData'    => $postData
        ]);
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