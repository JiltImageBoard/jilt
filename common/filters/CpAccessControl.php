<?php
/**
 * Created by PhpStorm.
 * User: elqua
 * Date: 25.03.2016
 * Time: 20:29
 */

namespace app\common\filters;

use app\common\filters\rules\CpAccessRule;
use yii\base\ActionFilter;

class CpAccessControl extends ActionFilter
{
    public $rules;

    public function beforeAction($action)
    {
        /**
         * @var CpAccessRule $RuleClass
         */
        $actionId = $this->getActionId($action);

        if (isset($this->rules[$actionId])) {
            $RuleClass = $this->rules[$actionId];
            if (class_exists($RuleClass)) {
                $ruleObj = new $RuleClass();
                if ($ruleObj instanceof CpAccessRule)
                    return $ruleObj->isAllowed();
            }
        }

        return true;
    }
}