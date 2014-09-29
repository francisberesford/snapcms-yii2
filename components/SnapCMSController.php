<?php
namespace snapcms\components;

use Yii;
use yii\web\Controller;

/**
 * The default controller for SnapCMS
 * 
 * @author Francis Beresford <francis@snapfrozen.com.au>
 * @version 0.1
 * @package snapcms.controllers
 */
class SnapCMSController extends Controller
{
    public $primaryMenu = [];
    
    public function init()
    {
        parent::init();
        
        $this->initPrimaryMenu();
        
        foreach(Yii::$app->getModules() as $id=>$module) 
        {
            if(is_array($module)) {
                $module = \Yii::$app->getModule($id);
            }
            if(is_object($module) && is_subclass_of($module, '\snapcms\components\SnapCMSModule')) {
                $this->primaryMenu = yii\helpers\ArrayHelper::merge(
                    $this->primaryMenu,
                    $module->primaryMenu
                );
            }
        }
    }
    
    protected function initPrimaryMenu()
    {
        $user = \Yii::$app->user;
        $this->primaryMenu = [
            ['label' => 'View Site', 'url' => Yii::$app->urlManagerFrontend->createUrl(['site/index'])],
            ['label' => 'Content', 'url' => ['/content/index'], 
                'visible' => 
                    $user->can('Create Content') || 
                    $user->can('Update Content') || 
                    $user->can('Delete Content') 
            ],
            ['label' => 'Menus', 'url' => ['/menu/update'], 
                'visible' => 
                    $user->can('Create Menu') || 
                    $user->can('Update Menu') || 
                    $user->can('Delete Menu') 
            ],
            ['label' => 'Users', 'url' => ['/user/admin'],
                'visible' => 
                    $user->can('Create User') || 
                    $user->can('Update User') || 
                    $user->can('Delete User') ||
                    $user->can('Manage User Groups'),
                'items' => [
                    ['label' => 'Users', 'url' => ['/user/index'], 
                        'visible' => 
                            $user->can('Create User') || 
                            $user->can('Update User') || 
                            $user->can('Delete User') 
                    ],
                    ['label' => 'Groups', 'url' => ['/user/groups'], 
                        'visible' => $user->can('Manage User Groups')],
                ],
            ],
            ['label' => 'Administration', 'url' => ['/user/admin'],
                'visible' => 
                    $user->can('Update Settings') || 
                    $user->can('Update Content Type Structure') || 
                    $user->can('View Logs'),
                'items' => [
                    ['label' => 'Settings', 'url' => ['/config/index'], 
                        'visible' => $user->can('Update Settings'),
                    ],
                    ['label' => 'Content Types', 'url' => ['/content/content-types'], 
                        'visible' => $user->can('Update Content Type Structure'),
                    ],
                    ['label' => 'Logs', 'url' => ['/site/logs'], 
                        'visible' => $user->can('View Logs'),
                    ],
                ],
            ],
        ];
    }
}
