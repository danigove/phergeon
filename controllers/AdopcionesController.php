<?php

namespace app\controllers;

use Yii;
use app\models\Adopciones;
use app\models\AdopcionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\helpers\Url;

/**
 * AdopcionesController implements the CRUD actions for Adopciones model.
 */
class AdopcionesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete', 'solicitar'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create','solicitar'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'delete'],
                        'roles' => ['@'],
                        // 'matchCallback' => function ($rule, $action) {
                        //     return $_GET['id'] == Yii::$app->user->identity->id;
                        // },
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Adopciones models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdopcionesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Adopciones model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Adopciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Adopciones();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Adopciones model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Adopciones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Adopciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Adopciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adopciones::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Manda una solicitud de adopción al usuario que subió el animal
     * @return mixed Redirecciona a Home si ha habido un error.
     */
    public function actionSolicitar()
    {
        if (Yii::$app->request->post()) {
            $model = new Adopciones();
            $model->id_usuario_donante = Yii::$app->request->post()['id_donante'];
            $model->id_animal = Yii::$app->request->post()['id_animal'];
            $model->id_usuario_adoptante = Yii::$app->user->identity->id;
            if ($model->id_usuario_donante == $model->id_usuario_adoptante) {
                Yii::$app->session->setFlash('error', '¡No puedes adoptar los animales que TÚ has subido!');
                return $this->goHome();
            }
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }
    }
}
