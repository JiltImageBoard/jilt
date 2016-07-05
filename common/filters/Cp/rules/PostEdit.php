<?php

namespace app\common\filters\cp\rules;

class PostEdit extends CpAccessRule
{
    public function isAllowed()
    {
        return
            parent::isAllowed() &&
            ($this->boardRights && $this->boardRights->canEditPosts) ||
            ($this->threadChatRights && $this->threadChatRights->canEditPosts);
    }

}