<?php

namespace app\controllers;

use Yii;
use app\models\Mensajes;
use app\models\MensajesSearch;
use yii\web\Controller;
use yii\filters\AccessControl;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MensajesController implements the CRUD actions for Mensajes model.
 */
class MensajesController extends Controller
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
                'only' => ['update', 'create', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['@'],
                    ],
                    [
                        // 'allow' => true,
                        // 'actions' => ['delete'],
                        // 'roles' => ['@'],
                        // 'matchCallback' => function ($rule, $action) {
                        //     return $_GET['id'] == Yii::$app->user->id;
                        // },
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Mensajes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MensajesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['id_receptor'=>Yii::$app->user->id])->orderBy(['created_at' => SORT_DESC]);

        foreach ($dataProvider->getModels() as $model) {
            $model->visto = true;
            $model->save();
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mensajes model.
     * @param integer $id
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
     * Creates a new Mensajes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mensajes();
        $model->id_emisor = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Mensaje enviado correctamente');
            return $this->goBack();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Mensajes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing Mensajes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Mensajes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mensajes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mensajes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
