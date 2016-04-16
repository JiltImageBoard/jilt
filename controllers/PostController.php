<?php

namespace app\controllers;

use app\common\filters\BanFilter;
use yii\web\Controller;

class PostController extends Controller
{

    public function actionCreate($name, $threadNum)
    {

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