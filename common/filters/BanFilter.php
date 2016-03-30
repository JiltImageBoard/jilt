<?php

namespace app\common\filters;

use app\common\classes\Ban;
use app\models\Board;
use app\models\Thread;
use yii\base\ActionFilter;

class BanFilter extends ActionFilter
{
    
    public function beforeAction($action)
    {
        $request = \Yii::$app->urlManager->parseRequest(\Yii::$app->request);
        $board = Board::findOne(['name' => 'test']);
        $thread = Thread::findOne(124);
        
        $ban = new Ban($board,$thread);
        return $ban->check();
    }
}