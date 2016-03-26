<?php

namespace app\common\filters;

use Yii;
use yii\base\ActionFilter;
use app\common\exceptions\InvalidCsrfTokenException;

class CsrfFilter extends ActionFilter
{

    public $csrfToken;

    public function beforeAction($action)
    {
        if (empty($this->csrfToken)) {
            throw new InvalidCsrfTokenException();
        }
        
        $session = \yii::$app->session;
        $session->open();
        
        
        if (!\yii::$app->getSecurity()->validatePassword($session->id, $this->csrfToken)) {
            //TODO: Сделать кастомный эксепшн? У этого формат не очень подходящий
            throw new InvalidCsrfTokenException();
        }
        return true;
    }
}