<?php
namespace snapcms\controllers;

use Yii;
use yii\filters\AccessControl;
use snapcms\components\SnapCMSController;
use snapcms\models\LoginForm;
use snapcms\models\Log;
use yii\filters\VerbFilter;
use yii\log\Logger;

/**
 * The default controller for SnapCMS
 * 
 * @author Francis Beresford <francis@snapfrozen.com.au>
 * @version 0.1
 * @package snapcms.controllers
 */
class SiteController extends SnapCMSController
{
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['logs'],
                        'allow' => true,
                        'roles' => ['View Logs'],
                    ],
                    [
                        'actions' => ['clear-logs'],
                        'allow' => true,
                        'roles' => ['Clear Logs'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Renders the index page
     * @return string the rendered view
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Renders the login form and processes the login form post.
     * @return string the rendered view
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    
    public function actionLogs($level = null)
    {
        $query = Log::find();
        if ($level)
        {
            $query->where('level=:level');
            $query->addParams([':level' => $level]);
        }
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'log_time' => SORT_ASC,
                ]
            ]
        ]);
        //$this->layout = '//layouts/column2';
        return $this->render('logs', [
            'dataProvider' => $dataProvider,
            'levels' => [Logger::LEVEL_ERROR, Logger::LEVEL_WARNING, Logger::LEVEL_INFO, Logger::LEVEL_TRACE],
            'selectedLevel' => $level,
        ]);
    }
    
    public function actionClearLogs()
    {
        Log::deleteAll();
        Yii::$app->session->setFlash('success', 'Logs cleared.');
        $this->redirect(['site/logs']);
    }

    /**
     * Logs the user out and redirects to the index page.
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
