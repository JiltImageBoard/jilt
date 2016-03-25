<?php

namespace app\common\filters\rules;

use yii\base\Object;
use Yii\web\User;

class CpAccessRule extends Object
{
    /**
     * @var User $user
     */
    private $user;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->user = \Yii::$app->user;
    }

    /**
     * @return bool
     */
    public function isAllowed()
    {
        return !$this->user->isGuest;
    }
}