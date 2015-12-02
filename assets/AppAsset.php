<?php
namespace snapcms\assets;

use Yii;
use yii\web\AssetBundle;
use yii\web\View;
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
    public $js = [
        'js/snapcms.js',
    ];
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
        $mId = $controller->module->id;
        
        $basePath = $controller->module->basePath;
        $relModLocJs = "/assets/js/$mId.js";
        $relModLocCss = "/assets/css/$mId.js";
        $relContLocJs = "/assets/js/$cId.js";
        $relContLocCss = "/assets/css/$cId.css";
        $relActLocJs = "/assets/js/$cId/$aId.js";
        $relActLocCss = "/assets/css/$cId/$aId.css";

        $modScriptFile = $basePath.$relModLocJs;
        $contScriptFile = $basePath.$relContLocJs;
        $actScriptFile = $basePath.$relActLocJs;
        $modCssFile = $basePath.$relModLocCss;
        $contCssFile = $basePath.$relContLocCss;
        $actCssFile = $basePath.$relActLocCss;

        if(file_exists($actScriptFile)) 
        {
            $manager = $view->getAssetManager();
            $paths = $manager->publish($actScriptFile);
            $view->registerJsFile($paths[1], ['position' => View::POS_END]);
        }
        if(file_exists($contScriptFile)) 
        {
            $manager = $view->getAssetManager();
            $paths = $manager->publish($contScriptFile);
            $view->registerJsFile($paths[1], ['position' => View::POS_END]);
        }
        if(file_exists($modScriptFile))
        {
            $manager = $view->getAssetManager();
            $paths = $manager->publish($modScriptFile);
            $view->registerJsFile($paths[1], ['position' => View::POS_END]);
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
        if(file_exists($modCssFile))
        {
            $manager = $view->getAssetManager();
            $paths = $manager->publish($modCssFile);
            $view->registerCssFile($paths[1]);
        }
    }
}
