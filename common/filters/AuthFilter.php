<?php

namespace app\common\filters;

use Yii;
use yii\base\ActionFilter;
use yii\web\UnauthorizedHttpException;

class AuthFilter extends ActionFilter
{
    
    public function beforeAction($action)
    {
        if (!\yii::$app->session->get('authorized')) {
            //TODO: Сделать кастомный эксепшн? У этого формат не очень подходящий
            throw new UnauthorizedHttpException();
        }
        return true;
    }
}