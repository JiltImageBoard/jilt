<?php

namespace app\common\filters\cp;

use app\common\filters\cp\rules\CpAccessRule;
use app\models\User;
use yii\base\ActionFilter;

class CpAccessControl extends ActionFilter
{
    private $rulesMap;

    public function init()
    {
        parent::init();
        $this->rulesMap = require(__DIR__ . '/rulesMap.php');
    }


    public function beforeAction($action)
    {
        $actionKey = $action->uniqueId;

        $user = User::findIdentity(14);
        \Yii::$app->user->login($user);

        /**
         * @var CpAccessRule $ruleObj
         */
        if (!isset($this->rulesMap[$actionKey])) return true;

        $RuleClass = $this->rulesMap[$actionKey];
        $ruleObj = new $RuleClass();
        if (!($ruleObj instanceof CpAccessRule)) {
            // TODO: throw some proper exception
            print_r('invalid cp access rule class');
            return false;
        }

        return $ruleObj->isAllowed();
    }
}