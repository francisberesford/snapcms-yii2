<?php

namespace snapcms\controllers;

use Yii;
use snapcms\models\Config;
use snapcms\ConfigSearch;
use snapcms\components\SnapCMSController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConfigController implements the CRUD actions for Config model.
 */
class ConfigController extends SnapCMSController
{
    public $layout = 'main';
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Config models.
     * @return mixed
     */
    public function actionIndex($category = 'General')
    {
        $post = Yii::$app->request->post();
        $allConfigData = Config::getOverrideArrayTree($category, $post);

        if(isset($post['Configs'])) {
            //The saving is actually done in getOverrideArrayTree. So we're cheating a bit.
            Yii::$app->session->setFlash('success','Configuration Saved');
        }
        
        $menuItems = Config::getCategoriesArray();
        $configData = $allConfigData[$category];

        return $this->render('index', [
            'configData' => $configData,
            'category' => $category,
            'menuItems' => $menuItems,
            //'dataProvider' => $dataProvider,
            //'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Config model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Config model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Config;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->path]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Config model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->path]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Config model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Config model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Config the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Config::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
