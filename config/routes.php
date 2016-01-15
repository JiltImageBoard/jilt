<?php

return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        /*Boards*/
        'GET boards/<boardName:\w+>' => 'boards/get',
        'POST boards' => 'boards/post',
        'PUT boards/<boardName:\w+>' => 'boards/update',
        'DELETE boards/<boardName:\w+>' => 'boards/delete',
        'GET boards/<boardName:\w+>/pages/<pageNum:\d+>' => 'boards/getPage',

        /*Threads*/
        'GET /boards/<boardName:\w+>/threads/<threadNum:\d+>' => 'threads/get',
        'POST /boards/<boardName:\w+>/threads' => 'threads/post',
        'PUT /boards/<boardName:\w+>/threads/<threadNum:\d+>' => 'threads/update',
        'DELETE /boards/<boardName:\w+>/threads/<threadNum:\d+>' => 'threads/delete',

        /*Chats*/
        'GET /boards/<boardName:\w+>/threads/<threadNum:\d+>/pages/<pageNum:\d+>' => 'threads/getPage',

        /*Posts*/
        'GET /boards/<boardName:\w+>/threads/<threadNum:\d+>/posts/<postNum:\d+>' => 'posts/get',
        'POST /boards/<boardName:\w+>/threads/<threadNum:\d+>/posts' => 'posts/post',
        'PUT /boards/<boardName:\w+>/threads/<threadNum:\d+>/posts/<postNum:\d+>' => 'posts/update',
        'DELETE /boards/<boardName:\w+>/threads/<threadNum:\d+>/posts/<postNum:\d+>' => 'posts/delete',

        /*Authentication*/
        'POST /control-panel/login' => 'auth/login',
        'POST /control-panel/logout' => 'auth/logout',
        'POST /control-panel/resetPassword' => 'auth/resetPassword',

        /*Users*/
        'GET /control-panel/users' => 'users/index',
        'POST /control-panel/users' => 'users/post',
        'GET /control-panel/users/<id:\d+>' => 'users/get',
        'PUT /control-panel/users/<id:\d+>' => 'users/update',
        'DELETE /control-panel/users/<id:\d+>' => 'users/delete',
        'GET /control-panel/users/<id:\d+>/cp-rights' => 'users/getCpRights',
        'PUT /control-panel/users/<id:\d+>/cp-rights' => 'users/updateCpRights',

        /*Board and chat rights*/
        'GET /control-panel/users/<id:\d+>/rights' => 'users/getRights',
        'PUT /control-panel/users/<id:\d+>/rights' => 'users/updateRights',

        /*Boards settings*/
        'GET /cintr'
    ]
];