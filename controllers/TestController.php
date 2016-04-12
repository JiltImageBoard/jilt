<?php

namespace app\controllers;

use app\common\classes\RelationData;
use app\models\Board;
use app\models\Thread;
<<<<<<< Temporary merge branch 1
use app\common\helpers\StringHelper;
use yii\base\Object;
=======
use app\models\User;
>>>>>>> Temporary merge branch 2
use yii\web\Controller;

class TestController extends Controller
{
    public function actionRun($name = 'test')
    {
<<<<<<< Temporary merge branch 1
        echo '<pre>';
        echo '</pre>';
=======
        
>>>>>>> Temporary merge branch 2
    }
}

class TestClass
{
    public static function test()
    {
        print_r("asdsadsa");
    }
}