<?php

namespace app\controllers;

use app\common\classes\ErrorMessage;
use app\common\filters\AuthFilter;
use app\common\filters\CsrfFilter;
use app\models\User;
use yii\web\Controller;

class UserController extends Controller
{

    public function actionCreate()
    {
        //TODO: Check rights

        $user = new User();
        if ($user->load(\yii::$app->request->post()) && $user->validate()) {
            $user->password = \yii::$app->getSecurity()->generatePasswordHash($user->password);
            $user->save();
            
            \Yii::$app->response->setStatusCode(201);
            return $this->actionGet($user->id);
        }
        return $user->errors;
    }
    
    public function actionGetAll()
    {
        $users = [];
        foreach (User::find()->all() as $user) {
            /**
             * @var User $user
             */
            $users[] = $user->toArray('password', 'cpRights', 'boardRights', 'chatRights');
        }

        return $users;

    }
    
    public function actionGet($id)
    {
        //TODO: Check rights user get only self related info
        return User::findOne($id)->toArray('password', 'salt');
    }
    
    public function actionUpdate($id)
    {
        //TODO: Check rights
        
        /**
         * @var User $user
         */
        $user = User::find()->where(['id' => $id])->limit(1)->one();
        
        if (!$user) {
            return ErrorMessage::ModelNotFound(User::className(), $id);
        }

        if (\yii::$app->getSecurity()->validatePassword(\yii::$app->request->post('password'), $user->password)) {
            $user->scenario = User::SCENARIO_UPDATE;
            if ($user->load(\yii::$app->request->post()) && $user->validate()) {
                $user->password = \yii::$app->getSecurity()->generatePasswordHash(\yii::$app->request->post('new_password'));
                $user->save();
                return $this->actionGet($user->id);
            }
        }
        return $user->errors;
    }


    /**
     * @param $id
     * @return void|array
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        //TODO: Check rights
        
        if (!User::find()->where(['id' => $id])->limit(1)->one()->delete()) {
            \Yii::$app->response->setStatusCode(404);
            return ErrorMessage::ModelNotFound(User::className(), $id);
        }
        \Yii::$app->response->setStatusCode(204);
    }
    
    public function actionGetCpRights($id)
    {
        //TODO: Check rights
        
    }

    public function actionUpdateCpRights($id)
    {
        //TODO: Check rights
    }

    public function behaviors()
    {
        return [
            [
                'class' => AuthFilter::className(),
            ],
            [
                'class' => CsrfFilter::className(),
                'only' => ['create', 'update', 'delete', 'update-cp-rights'],
                'csrfToken' => \yii::$app->request->post('csrf')
            ]
        ];
    }
}