<?php

namespace app\common\filters\cp\rules;

use app\common\helpers\ArrayHelper;
use app\models\Board;
use app\models\Thread;
use app\models\BoardRights;
use app\models\ThreadChatRights;

class PostDelete extends CpAccessRule
{
    public function isAllowed()
    {
        return
            parent::isAllowed() &&
            ($this->boardRights && $this->boardRights->canDeletePosts) ||
            ($this->threadChatRights && $this->threadChatRights->canDeletePosts);
    }
}
