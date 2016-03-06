<?php

namespace app\controllers;

use app\common\classes\RelationData;
use app\models\Board;
use app\models\Tag;
use app\models\Thread;
use app\common\helpers\StringHelper;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionRun($name = 'test')
    {
        $tag = Tag::findOne(['name' => 'TestTag']);
//        return $tag->threads;

        return $tag->parseTags();
    }
}