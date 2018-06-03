<?php

namespace app\controllers;

use app\models\Adopciones;
use app\models\AdopcionesSearch;
use app\models\Animales;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
                'only' => ['create', 'update', 'delete', 'solicitar', 'aprobar'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'solicitar'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['aprobar'],
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
            return $this->redirect(['animales/view', 'id' => $model->id_animal]);
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

        return $this->goBack();
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
     * Manda una solicitud de adopción al usuario que subió el animal.
     * @return mixed Redirecciona a Home si ha habido un error.
     */
    public function actionSolicitar()
    {
        if (Yii::$app->request->post()) {
            $id_animal = Yii::$app->request->post()['id_animal'];
            $animal = Animales::findOne(['id' => $id_animal]);
            if (!$animal->estaSolicitado($id_animal)) {
                $model = new Adopciones();
                $model->id_usuario_donante = Yii::$app->request->post()['id_donante'];
                $model->id_animal = $id_animal;
                $model->id_usuario_adoptante = Yii::$app->user->identity->id;
                if ($model->id_usuario_donante == $model->id_usuario_adoptante) {
                    Yii::$app->session->setFlash('error', '¡No puedes adoptar los animales que TÚ has subido!');
                    return $this->goHome();
                }
                $model->save();
                Yii::$app->session->setFlash('success', '¡Has solicitado la adopción correctamente!');
                return $this->redirect(['animales/view', 'id' => $model->id_animal]);
            }
            Yii::$app->session->setFlash('error', '¡Ya has solicitado este animal!');
            $this->redirect(['animales/view', 'id' => $id_animal]);
        }
    }

    /**
     * El usuario que donó el animal aprueba la solicitud de adopción para la
     * posterior entrega del animal.
     * @param  int $id  id de la adopcion
     * @return [type]     [description]
     */
    public function actionAprobar($id)
    {
        $model = Adopciones::findOne(['id' => $id]);
        if ($model->usuarioDonante->id == Yii::$app->user->id) {
            $model->aprobado = true;
            $model->save();
            Yii::$app->session->setFlash('success', '¡Enhorabuena, le has encontrado a ' . $model->animal->nombre . ' un buen hogar!');
            $solicitudes = Adopciones::deleteAll("id_animal = $model->id_animal and aprobado = false");
            $animales = Animales::deleteAll("id = $model->id_animal");
            $this->goBack();
        } else {
            Yii::$app->session->setFlash('error', 'No tienes permiso para aprobar esa adopción.');
            $this->redirect('animales/index');
        }
    }
}
