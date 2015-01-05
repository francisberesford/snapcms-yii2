<?php
return [
    'id' => 'snapcms',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'snapcms\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'user' => [
            'identityClass' => 'snapcms\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['info'],
                    'categories' => ['snapcms\*']
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'linkAssets' => true,
            //comment this out to use Gii
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ]
            ]
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => '',
            'rules' => [
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>'
            ],        
        ],
        'i18n' => [
            'translations' => [
                'snapcms*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@snapcms/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['Anonymous'],
        ],
        'view' => [
            'theme' => [
                'pathMap' => ['@snapcms/views' => '@frontend/themes/snapcms'],
                //'baseUrl' => '@web/themes/basic',
            ],
        ],
    ],
    //'params' => $params,
];
