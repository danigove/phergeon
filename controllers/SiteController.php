<?php

namespace app\controllers;

use app\models\Animales;
use app\models\ContactForm;
use app\models\LoginForm;
use app\models\Usuarios;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        // if (Yii::$app->request->post()) {
        //     var_dump(Yii::$app->request->post());
        //     die();
        // }
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $usuario = $model->getUser();
            $usuario->posx = $model->posx;
            $usuario->posy = $model->posy;
            $usuario->save();
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Busca y devuelve todos los animales cuya raza y/o tipo coincidan con el criterio de búsqueda
     * y/o todas las asociaciones que contengan en su nombre dicho criterio.
     * @return dataProvider   Todos los objetos
     */
    public function actionBuscar()
    {
        $criterio = Yii::$app->request->get('criterio');

        $dataProviderAso = new ActiveDataProvider([
               'query' => Usuarios::find()->joinWith('rol0')->where(['ilike', 'nombre_usuario', $criterio])->andWhere(['denominacion' => 'asociacion']),
           ]);

        $dataProviderAni = new ActiveDataProvider([
            'query' => Animales::find()->joinWith(['raza0', 'tipoAnimal'])->where(['ilike', 'denominacion_raza', $criterio])->orWhere(['ilike', 'denominacion_tipo', $criterio]),
        ]);


        return $this->render('resultado', [
            'string' => $criterio,
            'dataProviderAso' => $dataProviderAso,
            'dataProviderAni' => $dataProviderAni,
        ]);
    }
}
