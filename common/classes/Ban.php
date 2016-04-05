<?php

namespace app\common\classes;


use app\models\BanSettings;

/**
 * Class Ban
 * Checks if user banned by all data we can work with
 * 
 * @package app\common\classes
 */
class Ban
{
    private $board, $thread, $request,
    $ip, $name, $session, $message, $fileInfoId, $country,
    $reasonForUser, $reasonForMod, $bannedBy, $banUserOnViolation,
    $isProxy, $scenario;
    
    public function __construct($board, $thread)
    {
        $this->board = $board;
        
        if (!$thread) {
            $this->scenario = 'inBoard';
        } else {
            $this->thread = $thread;
            $this->scenario = 'inThread';
        }
        
        $this->request = \Yii::$app->request;
        
        $this->ip = $this->request->userIP;
        $this->name = $this->request->post('name');
        \Yii::$app->session->open();
        $this->session = \Yii::$app->session->id;
        $this->message = $this->request->post('text');
        $this->fileInfoId = $this->getFiles();
        $this->country = $this->getCountry();
        
        $this->banUserOnViolation = false;
        $this->isProxy = false;
    }
    
    /**
     * @param mixed|string $ip
     */
    public function setIp($ip)
    {
        //TODO: Proxy detect
        $this->ip = ip2long($ip);
    }

    /**
     * @param array|mixed $message
     */
    public function setMessage($message)
    {
        $this->message = empty($message) ? '' : $message ;
    }
    
    public function getCountry()
    {
        //TODO: Вычислять страну
        return '';
    }
    
    public function getFiles()
    {
        //TODO: Искать хеши файлов и заполнять массив айдишниками записей
        $ids = [];
        return $ids;
    }
    
    public function banStrict()
    {
        //TODO: Если вызывается этот метод, то глобально банить юзера абсолютно по всем имеющимся данным
    }

    public function check()
    {
        $query = BanSettings::find()
        ->select('
        bans_settings.ip as ip,
        bans_settings.subnet as subnet,
        bans_settings.name as name,
        bans_settings.session as session,
        bans_settings.message as message,
        bans_settings.files_info_id as fileId,
        bans_settings.country as country,
        bans_settings.created_at as createdAt,
        bans_settings.updated_at as updatedAt,
        bans_settings.banned_until as bannedUntil,
        bans_settings.reason_for_user as reasonForUser,
        bans_settings.banned_by as bannedBy,
        bans_settings.ban_user_on_violation as banUserOnViolation,
        bans_global.id as globalBanId,
        bans_boards.id as boardBanId
        ')
            
        /**
         *  Join bans_global, bans_boards and optionally bans_threads and bans_chat_pages
         */
        ->join('LEFT JOIN', 'bans_global', 'bans_global.bans_settings_id = bans_settings.id')
            
        ->join('LEFT JOIN', 'bans_boards', 'bans_boards.bans_settings_id = bans_settings.id')
                ->where(['bans_boards.id' => $this->board->id]);
        
        if ($this->scenario = 'inThread') {
            $query->join('LEFT JOIN', 'bans_threads', 'bans_threads.bans_settings_id = bans_settings.id')
            ->orWhere(['bans_threads.id' => $this->thread->id]);
        }
        
        //TODO: implement chats
        /**
        if ($this->scenario = 'inChat') {
            $query->join('INNER JOIN', 'bans_chat_pages', 'bans_chat_pages.bans_settings_id = bans_settings.id')
                ->orWhere(['bans_chat_pages.id' => $this->thread->id]);
        }
        */

        /**
         *  Select all data we can retrieve from user
         */
        $query->orWhere(['ip' => ip2long($this->ip)])
            ->orWhere(['name' => $this->name])
            ->orWhere(['session' => $this->session])
            ->orWhere(['message' => $this->message])
            ->orWhere(['files_info_id' => 1])
            ->orWhere(['country' => 'UA']);
        
        $asd = $query->createCommand()->rawSql;
        
        $desu = $query->all();
        foreach ($query->all() as $ban) {
            $bans[] = $ban;
        }
        return true;
    }
}