<?php

namespace snapcms\controllers;

use Yii;
use snapcms\models\User;
use snapcms\models\search\UserSearch;
use snapcms\components\SnapCMSController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends SnapCMSController
{    
    public $layout = '//column2';
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    //'delete-role' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['Create User','Update User','Delete User'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['Create User'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['Update User'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['Delete User'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['View User'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['groups', 'create-role', 'delete-role'],
                        'roles' => ['Manage User Groups'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('snapcms', 'User Created'));
            return $this->redirect(['index']);
        } else {
            $this->layout = '//main';
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('snapcms', 'User Updated'));
            return $this->redirect(['index']);
        } else {
            $this->layout = '//main';
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('success', Yii::t('snapcms', 'User Deleted'));
        }
        return $this->redirect(['index']);
    }
    
    /**
     * Manage user groups and permissions
     */
    public function actionGroups($role='Anonymous') 
    {
        $auth = Yii::$app->authManager;

        $post = Yii::$app->request->post('auth');
        if($post)
        {
            foreach($post as $group => $perms)
            {
                $roleObj = $auth->getRole($group);
                foreach($perms as $perm => $checked)
                {
                    $permObj = $auth->getPermission($perm);
                    $hasChild = $auth->hasChild($roleObj, $permObj);
                    if($checked && !$hasChild) {
                        $auth->addChild($roleObj, $permObj);
                    } else if(!$checked && $hasChild) {
                        $auth->removeChild($roleObj, $permObj);
                    }
                }
            }
            Yii::$app->session->setFlash('success','Permissions Saved.');
        }
        
        $roleNames = array();
        foreach ($auth->getRoles() as $r) {
            $roleNames[] = $r->name;
        }
        
        $permissions = $auth->getPermissions();
        
        $rootPermissions = [];
        foreach($permissions as $name => $perm)
        {
            $children = $auth->getChildren($name);
            if(count($children)) {
                $rootPermissions[$name] = $perm;
            }
        }

        $selectedPermissions = $auth->getPermissionsByRole($role);
        //var_dump($selectedPermissions);
        
        $this->layout = '//main';
        return $this->render('groups', array(
            'currentRole' => $role,
            'roleNames' => $roleNames,
            'rootPermissions' => $rootPermissions,
            'selectedPermissions' => $selectedPermissions,
            'auth' => $auth,
        ));
    }
    
    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateRole()
    {
        $auth = Yii::$app->authManager;
        
        if(isset($_POST['role']))
        {   
            $newRole = $auth->createRole($_POST['role']);
            if($auth->add($newRole))
            {
                Yii::$app->session->setFlash('success', 'Role created');
                return $this->redirect(['groups']);
            }
            else {
                Yii::$app->session->setFlash('danger', 'Error creating role');
            }
        }
        
        $this->layout = '//main';
        return $this->render('create_role');
    }
    
    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDeleteRole($role)
    {
        $auth = Yii::$app->authManager;
        
        $roleObj = $auth->getRole($role);
        if($auth->remove($roleObj)) {
            Yii::$app->session->setFlash('success', Yii::t('snapcms', 'Role removed'));
        } else {
            Yii::$app->session->setFlash('danger', Yii::t('snapcms', 'Error removing role'));
        }
        return $this->redirect(['groups']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
