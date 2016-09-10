<?php

namespace app\controllers;

use app\common\classes\ErrorMessage;
use app\common\filters\AuthFilter;
use app\common\filters\CsrfFilter;
use app\models\User;
use yii\web\Controller;

class AuthController extends Controller
{

    public function actionLogin()
    {
        $username = \yii::$app->request->post('username');
        $password = \yii::$app->request->post('password');
        
        /**
        * @var User $user
        */
        $user = User::find()->where('username = :username', [':username' => $username])->one();
        
        if (!$user) {
            \yii::$app->response->setStatusCode(401);
            return ErrorMessage::WrongCredentials();
        }
        
        if (\yii::$app->getSecurity()->validatePassword($password, $user->password)) {
            $session = \yii::$app->session;
            $session->set('authorized', true);
            $session->set('username', $user->username);
            $session->set('password', $user->password);
            \yii::$app->response->setStatusCode(200);
        } else {
            \yii::$app->response->setStatusCode(400);
            return ErrorMessage::WrongCredentials();
        }
        
    }

    public function actionLogout()
    {
        \yii::$app->session->open();
        \yii::$app->session->destroy();
        \yii::$app->response->setStatusCode(204);
    }

    public function actionResetPassword()
    {
        return 'Not implemented';
    }
    
    public function actionGetCsrfToken()
    {
        $session = \yii::$app->session;
        $session->open();
        return \yii::$app->getSecurity()->generatePasswordHash($session->id);
    }
    
//    public function behaviors()
//    {
//        return [
//            [
//                'class' => CsrfFilter::className(),
//                'only' => ['logout', 'reset-password'],
//                'csrfToken' => \yii::$app->request->post('csrf')
//            ]
//        ];
//    }
}