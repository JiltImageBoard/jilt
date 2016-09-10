<?php

namespace app\common\filters\cp\rules;

class PageEdit extends CpAccessRule
{
    public function isAllowed()
    {
        return
            parent::isAllowed() &&
            $this->threadChatRights && $this->threadChatRights->canEditPages;
    }
}
