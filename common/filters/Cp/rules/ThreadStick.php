<?php

namespace app\common\filters\cp\rules;

class ThreadStick extends CpAccessRule
{
    public function isAllowed()
    {
        return
            parent::isAllowed() &&
            $this->boardRights &&
            $this->boardRights->canStickThreads;
    }

}