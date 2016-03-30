<?php

namespace app\common\classes;


class Ban
{
    private $board, $thread, $request,
    $ip, $subnetwork, $name, $session, $message, $fileInfoId, $country,
    $reasonForUser, $reasonForMod, $bannedBy, $banUserOnViolation;
    
    public function __construct($board, $thread)
    {
        $this->board = $board;
        $this->thread = $thread;
        $this->request = \Yii::$app->request;
        
        $this->ip = $this->request->userIP;
//        $this->subnetwork =
    }
    
    public function check()
    {
        return true;
    }
}