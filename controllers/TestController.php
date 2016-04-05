<?php

namespace app\controllers;

use app\common\filters\cp\CpAccessControl;
use app\common\filters\cp\rules\CpAccessRule;
use app\models\Thread;
use app\models\User;
use yii\base\Object;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionRun($name = 'test')
    {
        /**
         * @var User $user
         */
        $user = User::findOne(14);
        var_dump($user->getBoardRights()->one());
    }

    public function actionDeletePost($name, $threadNum, $postNum)
    {
        print_r('secret text');
    }

    public function behaviors()
    {
        return [
            'cpAccess' => [
                'class' => CpAccessControl::className()
            ]
        ];
    }
}