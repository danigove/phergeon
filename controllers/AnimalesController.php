<?php

namespace app\controllers;

use app\models\Animales;
use app\models\AnimalesSearch;
use Yii;
use app\models\SolicitarAdopcionForm;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AnimalesController implements the CRUD actions for Animales model.
 */
class AnimalesController extends Controller
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
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'delete'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Animales::findOne($_GET['id'])->id_usuario  == Yii::$app->user->identity->id;
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Animales models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AnimalesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Animales model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'content' => $model->rutaAnimal($id),
        ]);
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:type',
            'content' => 'website',
        ]);
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:title',
            'content' => 'Ayudalo',
        ]);
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'content' => $model->rutaAnimal($id),
        ]);
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:description',
            'content' => $model->descripcion,
        ]);

        $solicitarAdopcionForm = new SolicitarAdopcionForm([
            'id_donante' => $model->id_usuario,
            'id_animal' => $model->id,
        ]);

        return $this->render('view', [
            'solicitarAdopcionForm' => $solicitarAdopcionForm,
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Animales model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Animales();

        $model->id_usuario = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Animales model.
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
     * Deletes an existing Animales model.
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
     * Finds the Animales model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Animales the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Animales::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
