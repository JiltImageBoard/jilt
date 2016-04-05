<?php

namespace app\common\filters\cp\rules;


class Ban extends CpAccessRule
{
    public function isAllowed()
    {
        return
            parent::isAllowed() &&
            ($this->boardRights && $this->boardRights->canBan) ||
            ($this->threadChatRights && $this->threadChatRights->canBan);
    }
}