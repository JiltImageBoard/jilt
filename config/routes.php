<?php

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        /* Boards */
        'POST boards/?' => 'board/create',
        'GET boards/?' => 'board/get-all',
        'GET boards/<name:\w+>/pages/<pageNum:\d+>/?' => 'board/get-page',
        'GET boards/<name:\w+>/?' => 'board/get',
        'PUT boards/<name:\w+>/?' => 'board/update',
        'DELETE boards/<name:\w+>/?' => 'board/delete',

        /* Threads */
        'GET boards/<name:\w+>/threads/<threadNum:\d+>/?' => 'thread/get',
        'POST boards/<name:\w+>/threads/?' => 'thread/create',
        'PUT boards/<name:\w+>/threads/<threadNum:\d+>/?' => 'thread/update',
        'DELETE boards/<name:\w+>/threads/<threadNum:\d+>/?' => 'thread/delete',

        /* Chats */
        'GET boards/<name:\w+>/threads/<threadNum:\d+>/pages/<pageNum:\d+>/?' => 'thread/get-page',

        /* Posts */
        'GET boards/<name:\w+>/threads/<threadNum:\d+>/posts/<postNum:\d+>/?' => 'post/get',
        'POST boards/<name:\w+>/threads/<threadNum:\d+>/posts/?' => 'post/create',
        'PUT boards/<name:\w+>/threads/<threadNum:\d+>/posts/<postNum:\d+>/?' => 'post/update',
        'DELETE boards/<name:\w+>/threads/<threadNum:\d+>/posts/<postNum:\d+>/?' => 'post/delete',

        /* Authentication */
        'POST control-panel/login/?' => 'auth/login',
        'POST control-panel/logout/?' => 'auth/logout',
        'GET control-panel/logout/?' => 'auth/logout', /* временно */ 
        'POST control-panel/reset-password/?' => 'auth/reset-password',
        'GET  control-panel/csrf-token/?' => 'auth/get-csrf-token',

        /* Users */
        'GET control-panel/users/?' => 'user/get-all',
        'POST control-panel/users/?' => 'user/create',
        'GET control-panel/users/<id:\d+>/?' => 'user/get',
        'PUT control-panel/users/<id:\d+>/?' => 'user/update',
        'DELETE control-panel/users/<id:\d+>/?' => 'user/delete',

        /* Board and chat rights */
        'GET control-panel/users/<id:\d+>/rights/?' => 'user/get-rights',
        'PUT control-panel/users/<id:\d+>/rights/?' => 'user/update-rights',

        /* Bans */
        'GET bans/?' => 'ban/get-all',
        'POST bans/?' => 'ban/create',
        'GET bans/<id:\d+>/?' => 'ban/get',
        'PUT bans/<id:\d+>/?' => 'ban/update',
        'DELETE bans/<id:\d+>/?' => 'ban/delete',

        /* Tests */
        '/test/?' => 'test/run',
        'GET test/delete-post/<name:\w+>/<threadNum:\d+>/<postNum:\d+>/?' => 'test/delete-post',

        /* Error handler */
        '<controller:[\S\s]+>' => 'error/not-found'
    ]
];