<?php

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        /*Boards*/
        'POST boards/?' => 'board/create',
        'GET boards/?' => 'board/get-all',
        'GET boards/<name:\w+>/pages/<pageNum:\d+>' => 'board/get-page',
        'GET boards/<name:\w+>' => 'board/get',
        'PUT boards/<name:\w+>' => 'board/update',
        'DELETE boards/<name:\w+>' => 'board/delete',

        /*Threads*/
        'GET boards/<name:\w+/threads/<threadNum:\d+>' => 'thread/get',
        'POST boards/<name:\w+>/threads' => 'thread/create',
        'PUT boards/<name:\w+>/threads/<threadNum:\d+>' => 'thread/update',
        'DELETE boards/<name:\w+>/threads/<threadNum:\d+>' => 'thread/delete',

        /*Chats*/
        'GET boards/<name:\w+>/threads/<threadNum:\d+>/pages/<pageNum:\d+>' => 'thread/getPage',

        /*Posts*/
        'GET boards/<name:\w+>/threads/<threadNum:\d+>/posts/<createNum:\d+>' => 'post/get',
        'POST boards/<name:\w+>/threads/<threadNum:\d+>/posts' => 'post/create',
        'PUT boards/<name:\w+>/threads/<threadNum:\d+>/posts/<createNum:\d+>' => 'post/update',
        'DELETE boards/<name:\w+>/threads/<threadNum:\d+>/posts/<createNum:\d+>' => 'post/delete',

        /*Authentication*/
        'POST login' => 'auth/login',
        'POST logout' => 'auth/logout',
        'POST /resetPassword' => 'auth/resetPassword',

        /*Users*/
        'GET users' => 'user/index',
        'POST users' => 'user/create',
        'GET users/<id:\d+>' => 'user/get',
        'PUT users/<id:\d+>' => 'user/update',
        'DELETE users/<id:\d+>' => 'user/delete',
        'GET users/<id:\d+>/cp-rights' => 'user/getCpRights',
        'PUT users/<id:\d+>/cp-rights' => 'user/updateCpRights',

        /*Board and chat rights*/
        'GET users/<id:\d+>/rights' => 'user/getRights',
        'PUT users/<id:\d+>/rights' => 'user/updateRights',

        /*Bans*/
        'GET bans' => 'ban/index',
        'POST bans' => 'ban/create',
        'GET bans/<id:\d+>' => 'ban/get',
        'PUT bans/<id:\d+>' => 'ban/update',
        'DELETE bans/<id:\d+>' => 'ban/delete',

        /*Tests*/
        '/test' => 'test/run',

        /* Error handler */
        '<controller:[\S\s]+>' => 'error/resource-not-found'
    ]
];