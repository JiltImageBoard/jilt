<?php

namespace app\controllers;

use yii\web\Controller;

class ErrorController extends Controller
{
    protected $errorCode, $errorMessage;
    const AUTH_REQUIRED = 1;
    const NOT_ALLOWED = 2;
    const BANNED = 3;
    const RESOURCE_NOT_FOUND = 4;

    private function errorTemplate($errorCode, $errorMessage)
    {
        return [
            'errorCode' => $errorCode,
            'errorMessage' => $errorMessage
        ];
    }

    public function actionAuthRequired()
    {
        return $this->errorTemplate(self::AUTH_REQUIRED, 'Auth required');
    }

    public function actionNotAllowed()
    {
        return $this->errorTemplate(self::NOT_ALLOWED, 'Not allowed');
    }

    public function actionBanned()
    {
        return $this->errorTemplate(self::BANNED, [
            'BanReason' => 'Reason',
            'BanMessage' => 'Message',
            'BanDate' => '22:22:22 2017/05/05',
            'BannedBy' => 'Admin'
        ]);
    }

    public function actionResourceNotFound()
    {
        return $this->errorTemplate(self::RESOURCE_NOT_FOUND, 'Not found');
    }
}