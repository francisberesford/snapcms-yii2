<?php

return yii\helpers\ArrayHelper::merge(
    //require(__DIR__ . '/../../../../../frontend/config/main.php'),
    require(__DIR__ . '/../../../../../frontend/config/main-local.php'),
    require(__DIR__ . '/../../config/console.php'),
    [
        'components' => [
            'db' => [
                'dsn' => 'mysql:host=localhost;dbname=snapcms_yii2_unit',
            ],
        ],
    ]
);
