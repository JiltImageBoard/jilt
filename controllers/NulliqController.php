<?php

namespace app\controllers;

use app\models\BoardSettings;
use app\models\Board;
use app\models\PostData;
use app\models\PostMessage;
use app\models\Tag;
use app\models\Thread;
use app\models\ThreadTag;
use Faker\Provider\File;
use yii\base\Model;
use yii\web\Controller;
use app\common\helpers\DataFormatter;
use app\models\FileFormat;

class NulliqController extends Controller
{

    /**
     * @param string $name имя борды
     * @param int $pageNum
     */
    public function actionRun($boardName = 'test')
    {

    }
}