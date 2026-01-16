<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$config = [
    'on beforeRequest' => function ($event) {
    	Yii::$app->language = Yii::$app->session->get('language', 'en');
     },
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
         'i18n' => [
        'translations' => [
            'frontend*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@common/messages',
                'forceTranslation' => true,
            ],
            'backend*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@common/messages',
                'forceTranslation' => true,
            ],
        ],
    ],
	// Override the urlManager component
        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',

            // List all supported languages here
            // Make sure, you include your app's default language.
            'languages' => ['lv-LV', 'lv', 'ru'],
            'enablePrettyUrl' => true,
            'showScriptName' => false, // Only considered when enablePrettyUrl is set to true
            
            
        ],
        'db' => [
        'class' => '\yii\db\Connection',
        'dsn' => 'mysql:host=mysql;dbname=yii2advanced',
        'username' => 'yii2advanced',
        'password' => 'secret123',
        'charset' => 'utf8',
    ],
    'cart' => [
            'class' => 'yii2mod\cart\Cart',
            // you can change default storage class as following:
            'storageClass' => [
                'class' => 'yii2mod\cart\storage\DatabaseStorage',
                // you can also override some properties 
                'deleteIfEmpty' => true
            ]
        ],

        // ...
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
     // set target language to be Russian
    'language' => 'lv_LV',

    // set source language to be English
    'sourceLanguage' => 'en-US',
];
