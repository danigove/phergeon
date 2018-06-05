<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MensajesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis mensajes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mensajes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'emisor.nombre_usuario',
            'asunto',
            'mensaje',
            // 'visto',
            'created_at',

            [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {update} {delete}',
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    if (!Yii::$app->user->isGuest &&
                                        ($model->receptor->id == Yii::$app->user->identity->id)) {
                                        Modal::begin([
                                            'header' => '<h4>Mensaje para '. $model->emisor->nombre_usuario.'</h4>',
                                            'toggleButton' => ['label' => 'Contactar'],
                                        ]);
                                        echo  $this->render('../mensajes/_formRespuesta', [
                                            'model' => $model,
                                        ]);

                                        Modal::end();
                                    }
                                },
                                'delete' => function ($url, $model, $key){
                                    if (!Yii::$app->user->isGuest &&
                                        ($model->receptor->id == Yii::$app->user->identity->id)) {
                                        return Html::a('', ['delete', 'id' => $model->id], [
                                            'class' => 'glyphicon glyphicon-trash',
                                            'data' => [
                                                'confirm' => '¿Estás seguro que quieres borrar este envio?',
                                                'method' => 'post',
                                            ],
                                        ]);
                                    }
                                },

                            ],
                        ],
        ],
    ]); ?>
</div>
