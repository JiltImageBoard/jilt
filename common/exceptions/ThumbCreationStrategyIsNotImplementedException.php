<?php

namespace app\common\exceptions;

use yii\web\HttpException;

class ThumbCreationStrategyIsNotImplementedException extends HttpException
{
    public function __construct($extension)
    {
        $message = 'Thumb creation strategy is not implemented for [' . $extension . '] files';
        parent::__construct(400, $message);
    }
}