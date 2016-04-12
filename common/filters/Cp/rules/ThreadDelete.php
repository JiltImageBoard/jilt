<?php

namespace app\common\filters\cp\rules;

class ThreadDelete extends CpAccessRule
{
    public function isAllowed()
    {
        return
            parent::isAllowed() &&
            $this->boardRights &&
            $this->boardRights->canDeleteThreads;
    }

}
