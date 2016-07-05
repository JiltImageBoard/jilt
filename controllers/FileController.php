<?php

namespace app\controllers;

use app\models\FileInfo;
use yii\web\Controller;

class FileController extends Controller
{
    public function actionExists($hash)
    {
        return FileInfo::find()->where(['hash' => $hash])->exists();
    }
}