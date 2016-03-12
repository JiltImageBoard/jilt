<?php

namespace app\controllers;

use app\common\classes\Encryption;
use app\common\classes\Errors;
use app\common\filters\AuthFilter;
use app\models\User;
use yii\web\Controller;

class UserController extends Controller
{

    public function actionCreate()
    {
        //TODO: Check rights
        
        $user = new User();
        if($user->load(\yii::$app->request->post()) && $user->validate()) {
            $user->salt = Encryption::getRandomString();
            $user->password = Encryption::hashPassword($user->password);
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
            $users[] = [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ];
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
            return Errors::ModelNotFound(User::className(), $id);
        }
        
        if ($user->checkPassword(Encryption::hashPassword(\yii::$app->request->post('password')), $user->password)) {
            if ($user->load(\yii::$app->request->post()) && $user->validate()) {
                $user->password = Encryption::hashPassword($user->password);
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
            return Errors::ModelNotFound(User::className(), $id);
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
            'customFilter' => [
                'class' => AuthFilter::className(),
            ]
        ];
    }
}