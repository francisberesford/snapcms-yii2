<?php
namespace snapcms\assets;

use Yii;
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
    ];
    public $js = [];
    public $depends = [
        'yii\web\YiiAsset',
        'snapcms\assets\FontAwesomeAsset',
    ];
    
    public function registerAssetFiles($view)
    {
        parent::registerAssetFiles($view);
        $controller = Yii::$app->controller;
        
        $cId = $controller->id;
        $aId = $controller->action->id;
        
        $basePath = $controller->module->basePath;
        $relContLocJs = "/assets/js/$cId.js";
        $relContLocCss = "/assets/css/$cId.css";
        $relActLocJs = "/assets/js/$cId/$aId.js";
        $relActLocCss = "/assets/css/$cId/$aId.css";
        
        $contScriptFile = $basePath.$relContLocJs;
        $actScriptFile = $basePath.$relActLocJs;
        $contCssFile = $basePath.$relContLocCss;
        $actCssFile = $basePath.$relActLocCss;
        
        if(file_exists($actScriptFile)) 
        {
            $manager = $view->getAssetManager();
            $paths = $manager->publish($actScriptFile);
            $view->registerJsFile($paths[1], ['position' => \yii\web\View::POS_END]);
        }
        if(file_exists($contScriptFile)) 
        {
            $manager = $view->getAssetManager();
            $paths = $manager->publish($contScriptFile);
            $view->registerJsFile($paths[1], ['position' => \yii\web\View::POS_END]);
        }
        if(file_exists($actCssFile)) 
        {
            $manager = $view->getAssetManager();
            $paths = $manager->publish($actCssFile);
            $view->registerCssFile($paths[1]);
        }
        if(file_exists($contCssFile)) 
        {
            $manager = $view->getAssetManager();
            $paths = $manager->publish($contCssFile);
            $view->registerCssFile($paths[1]);
        }
    }
}
