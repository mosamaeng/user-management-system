<?php
namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['profile', 'update'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'delete', 'view'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->can('manageUsers');
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['not', ['id' => Yii::$app->user->id]]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate()
    {
        $model = new User();
        $model->scenario = 'create';
    
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Assign role to the user
            $auth = Yii::$app->authManager;
            if ($model->role === 'user') {
                $userRole = $auth->getRole('user');
                $auth->assign($userRole, $model->id);
            } elseif ($model->role === 'admin') {
                $adminRole = $auth->getRole('admin');
                $auth->assign($adminRole, $model->id);
            }
    
            return $this->redirect(['view', 'id' => $model->id]);
        }
    
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    public function actionProfile()
    {
        $model = $this->findModel(Yii::$app->user->id);
        $model->scenario = 'update';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Profile updated successfully.');
            return $this->redirect(['profile']);
        }
        return $this->render('profile', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        $model = User::find()
        ->select(['id', 'username', 'email', 'role', 'created_at', 'updated_at'])
        ->where(['id' => $id])
        ->one();

    if ($model !== null) {
        return $model;
    }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}