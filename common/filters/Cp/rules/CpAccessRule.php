<?php

namespace app\common\filters\cp\rules;

use app\models\Board;
use app\models\BoardRights;
use app\models\ThreadChatRights;
use app\models\User;
use yii\base\Object;

class CpAccessRule extends Object
{
    /**
     * @var User
     */
    protected $user;
    /**
     * @var BoardRights
     */
    protected $boardRights;
    /**
     * @var ThreadChatRights
     */
    protected $threadChatRights;

    public function init()
    {
        parent::init();
        $this->user = \Yii::$app->user->identity;
        $actionParams = \Yii::$app->urlManager->parseRequest(\Yii::$app->request)[1];

        if (!isset($actionParams['name'])) return;
        $name = $actionParams['name'];
        $board = Board::find()->where(['name' => $name])->one();
        if (!$board) return;

        $this->boardRights = $this->user->getBoardRights($board->id)->one();

        if (!isset($actionParams['threadNum'])) return;
        $threadNum = $actionParams['threadNum'];
        $thread = $board->getThreads()->where(['number' => $threadNum])->one();
        $this->threadChatRights = $this->user->getThreadChatRights($thread->id)->one();
    }

    /**
     * @return bool
     */
    public function isAllowed()
    {
        return !\Yii::$app->user->isGuest;
    }
}