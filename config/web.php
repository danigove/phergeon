<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$log = require __DIR__ . '/log.php';

$config = [
    'id' => 'basic',
    'name' => 'Phergeon',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@uploads' => '@app/uploads',
    ],
    'language' => 'es-ES',
    'components' => [
        'session' => [
            'class' => 'yii\web\DbSession',
            'writeCallback' => function ($session) {
                return [
                'user_id' => Yii::$app->user->isGuest ? '' : Yii::$app->user->id,
                ];
            },
            // 'db' => 'mydb',  // el identificador del componente de aplicación DB connection. Por defecto'db'.
            // 'sessionTable' => 'my_session', // nombre de la tabla de sesión. Por defecto 'session'.
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '6K0G8kzVBf2yoUJkJvKZqGzYaJ3V30Os',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Usuarios',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            // comment the following array to send mail using php's mail function:
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => $params['adminEmail'],
                'password' => getenv('SMTP_PASS'),
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'log' => $log,
        'db' => $db,
        'formatter' => [
            'timeZone' => 'Europe/Madrid',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
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
