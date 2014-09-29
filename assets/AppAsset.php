<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace snapcms\assets;

use yii\web\AssetBundle;
//use yii\bootstrap\BootstrapAsset;

/**
 * @author Francis Beresford <francis@snapfrozen.com.au>
 * @since 2.0
 */
class AppAsset extends AssetBundle {

    public $sourcePath = '@snapcms/assets';
    public $css = [
        'css/snapcms.css',
        //'css/admin.css',
        //'css/bootstrap-theme.css',
    ];
    public $js = [];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];

}
