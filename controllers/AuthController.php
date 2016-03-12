<?php

namespace app\controllers;

use app\common\classes\Encryption;
use app\common\classes\Errors;
use app\common\filters\AuthFilter;
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
            return Errors::WrongCredentials();
        }
        
        if ($user->checkPassword(Encryption::hashPassword($password), $user->password)) {
            $session = \yii::$app->session;
            $session->set('authorized', 'true');
            $session->set('username', $user->username);
            $session->set('password', $user->password);
            \yii::$app->response->setStatusCode(200);
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
        return 'reset pass';
    }
    
    public function actionGetCsrfToken()
    {
        /**
         * @var User $user
         */
        $user = User::getUserBySession();
        return Encryption::getCsrfToken($user);
    }

    public function behaviors()
    {
        return [
            'customFilter' => [
                'class' => AuthFilter::className(),
                'only' => ['logout', 'reset-password', 'get-csrf-token']
            ]
        ];
    }
}