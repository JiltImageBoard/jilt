<?php

namespace app\common\filters\cp\rules;

class ThreadLock extends CpAccessRule
{
    public function isAllowed()
    {
        return
            parent::isAllowed() &&
            $this->boardRights &&
            $this->boardRights->canLockThreads;
    }

}