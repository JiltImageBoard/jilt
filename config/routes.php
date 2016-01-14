<?php

return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        /*Board methods*/
        'GET boards/<boardName:\w+>' => 'boards/get',
        'POST boards' => 'boards/post',
        'PUT boards/<boardName:\w+>' => 'boards/update',
        'DELETE boards/<boardName:\w+>' => 'boards/delete',
        'GET boards/<boardName:\w+>/pages/<pageNum:\d+>' => 'boards/getPage',

        /*Thread methods*/
        'GET /boards/<boardName:\w+>/threads/<threadNum:\d+>' => 'threads/get',
        'POST /boards/<boardName:\w+>/threads' => 'threads/post',
        'PUT /boards/<boardName:\w+>/threads/<threadNum:\d+>' => 'threads/update',
        'DELETE /boards/<boardName:\w+>/threads/<threadNum:\d+>' => 'threads/delete',

        /*Chat methods*/
        'GET /boards/<boardName:\w+>/threads/<threadNum:\d+>/pages/<pageNum:\d+>' => 'threads/getPage',

        /*Post methods*/
        'GET /boards/<boardName:\w+>/threads/<threadNum:\d+>/posts/<postNum:\d+>' => 'posts/get',
        'POST /boards/<boardName:\w+>/threads/<threadNum:\d+>/posts' => 'posts/post',
        'PUT /boards/<boardName:\w+>/threads/<threadNum:\d+>/posts/<postNum:\d+>' => 'posts/update',
        'DELETE /boards/<boardName:\w+>/threads/<threadNum:\d+>/posts/<postNum:\d+>' => 'posts/delete',

        /*Authentication*/
        'POST /control-panel/login' => 'controlPanel/login',
        'POST /control-panel/logout' => 'controlPanel/logout',
        'POST /control-panel/resetPassword' => 'controlPanel/resetPassword'
    ]
];