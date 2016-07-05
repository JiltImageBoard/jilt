<?php

namespace app\common\exceptions;

use yii\web\HttpException;

class FileDoesNotExistException extends HttpException
{
    public function __construct($message = 'FIle does not exists')
    {
        parent::__construct(400, $message);
    }
}