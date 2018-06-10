<?php

namespace app\controllers;

use app\models\Adopciones;
use app\models\Animales;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
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
                'only' => ['update', 'create', 'delete', 'solicitudes'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return $_GET['id'] == Yii::$app->user->identity->id;
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['solicitudes'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return $_GET['id'] == Yii::$app->user->id;
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return $_GET['id'] == Yii::$app->user->id;
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuarios model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $animales = new ActiveDataProvider([
                'query' => Animales::find()->where(['id_usuario' => $model->id]),
            ]);


        return $this->render('view', [
            'model' => $model,
            'animales' => $animales,
        ]);
    }

    /**
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuarios(['scenario' => Usuarios::ESCENARIO_CREATE]);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->foto = UploadedFile::getInstance($model, 'foto');
            if ($model->upload() && $model->save()) {
                return $this->goHome();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Usuarios::ESCENARIO_UPDATE;
        $model->password = '';

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * [actionSolicitudes description].
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function actionSolicitudes($id)
    {
        $usuario = Usuarios::findOne(['id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => Adopciones::find()->joinWith(['animal', 'usuarioAdoptante'])->where(['id_usuario_donante' => $id, 'aprobado' => false]),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => ['id_usuario_adoptante' => SORT_DESC],
            ],
        ]);

        return $this->render('solicitudes', [
            'model' => $usuario,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * [public description].
     * @var [type]
     */
    public function actionAsociacion()
    {
        $token_val = Yii::$app->request->get('token');
        $usuario = Usuarios::findOne(['token_val' => $token_val]);
        if (!Yii::$app->user->isGuest && $usuario->id === Yii::$app->user->id) {
            if ($usuario->rol == 2) {
                Yii::$app->session->setFlash('error', 'El usuario ya era una asociación animalista');
            } else {
                $usuario->rol = 2;
                $usuario->save();
                Yii::$app->session->setFlash('success', '¡Felicidades! Ya estás establecido como una asociación.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Necesitas estar logueado como el usuario que se quiere validar para completar esta acción.');
            $this->redirect(['site/login']);
        }
        $this->redirect(['usuarios/view', 'id' => $usuario->id]);
    }

    /**
     * Deletes an existing Usuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $animales = Animales::findAll(['id_usuario' => $id]);
        for ($i = 0; $i < count($animales); $i++) {
            $this->encontrarAnimal($animales[$i]['id'])->delete();
        }

        $this->findModel($id)->delete();

        return $this->redirect(['site/index']);
    }

    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Encuentra un animal.
     * @param  int $id id de animal que queremos encontrar
     * @return Animales Devuelve la instancia de animal con ese id.
     */
    protected function encontrarAnimal($id)
    {
        if (($model = Animales::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
