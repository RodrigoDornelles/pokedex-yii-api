<?php

$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'pokedex',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'enableCookieValidation' => false
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
        'response' => [
            'format' => 'json',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                // merge key data with data to prevent ambigous
                if (is_array($response->data) && isset($response->data['data'])) {
                    $response->data = array_merge(
                        ['success' => $response->isSuccessful],
                        $response->data,
                    );
                }
                // standarnization of result
                else {
                    $response->data = [
                        'success' => $response->isSuccessful,
                        'data' => $response->data,
                    ];
                }
                $response->statusCode = 200;
            },
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'rules' => [
                '<controller:[-\w]+>/<action:[-\w]+>/<id:[-\d]+>' => '<controller>/<action>',
                '<controller:[-\w]+>/<action:[-\w]+>' => '<controller>/<action>',
                '<controller:[-\w]+>/' => '<controller>/index',
                '/' => 'status/index',
            ],
        ],
        'db' => $db,
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
