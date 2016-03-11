<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'jilt-backend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'yg332mbLR7ks-mcVk86E1_4rahimpbzr0bw',
            'enableCsrfValidation' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'useMemcached' => true,
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'error/test',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => require(__DIR__ . '/routes.php'),
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ],
        'session' => [
            'class' => 'yii\web\CacheSession',
            'cache' => 'cache',
        ]
    ],
    'controller' => [
        'class' => 'yii\web\Controller',
        'enableCsrfValidation' => false,
    ],
    'params' => $params,
    'defaultRoute' => 'board/get-all',
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
