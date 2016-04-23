<?php

namespace app\common\exceptions;

use yii\web\HttpException;

class FileFormatWasNotSpecifiedException extends HttpException
{
    public function __construct($message = 'File format was not specified')
    {
        parent::__construct(400, $message);
    }
}