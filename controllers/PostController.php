<?php

namespace app\controllers;

use app\common\filters\BanFilter;
use yii\web\Controller;

class PostController extends Controller
{

    public function actionGet($name, $threadNum, $postNum)
    {
        return 'Not implemented';
    }
    
    public function actionCreate($name, $threadNum)
    {
        return 'Not implemented';
    }
    
    public function actionUpdate($name, $threadNum, $postNum)
    {
        return 'Not implemented';
    }
    
    public function actionDelete($name, $threadNum, $postNum)
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