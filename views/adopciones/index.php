<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdopcionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adopciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adopciones-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Adopciones', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_usuario_donante',
            'id_usuario_adoptante',
            'id_animal',
            'fecha_adopcion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
