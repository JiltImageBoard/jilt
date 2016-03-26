<?php

namespace app\controllers;

use app\models\ActiveRecordExtended;
use app\models\Board;
use app\models\Thread;
use app\models\User;
use yii\db\ActiveRecord;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionRun($name = 'test')
    {
        /**
         * @var Board $board
         */
        $board = Board::find()->one();
        print_r($board->toArray(['isClosed']));

        /*$test = new TestMessage();
        $test->text = 'adas';
        $test->save();*/
    }
}

class TestMessage extends ActiveRecord
{
    public static function tableName()
    {
        return 'post_messages';
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        print_r($this->isNewRecord ? "true" : "false");
    }


}