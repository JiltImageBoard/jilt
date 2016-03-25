<?php

namespace app\controllers;

use app\common\filters\CpAccessControl;
use app\common\filters\rules\CpAccessRule;
use app\models\Thread;
use app\models\User;
use yii\base\Object;
use yii\filters\AccessControl;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionRun($name = 'test')
    {
        print_r("test");
    }

    public function behaviors()
    {
        return [
            'cpAccess' => [
                'class' => CpAccessControl::className(),
                // in the rules for evry action we need we specifying some child of CpAccessRule
                'rules' => [
                    'run' => CpAccessRule::className()
                ]
            ]
        ];
    }
}