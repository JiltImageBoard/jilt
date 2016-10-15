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
use app\services\ThreadService;
use Faker\Provider\File;
use yii\base\Model;
use yii\base\Module;
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
     * @param string $boardName
     * @return array|string
     */
    public function actionCreate($boardName)
    {
        $data = Yii::$app->request->post();

        if (Yii::$app->request->isAjax) {
            /** @var Board $board */
            if (!$board = Board::findOne(['name' => $boardName])) {
                throw new UserException('Board was not found', 404);
            }

            $thread = ThreadService::create($board, $data);
            return $thread;
        } else {
            return $this->render('create', [
                'thread' => new Thread(),
                'postData' => new PostData()
            ]);
        }
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