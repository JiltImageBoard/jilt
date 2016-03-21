<?php

namespace app\common\exceptions;

use yii\web\HttpException;

class NotImplementedException extends HttpException
{
    public function __construct($message = 'Method is not implemented')
    {
        parent::__construct(501, $message);
    }
}