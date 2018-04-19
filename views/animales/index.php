<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AnimalesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Animales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="animales-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if(!Yii::$app->user->isGuest): ?>
    <p>
        <?= Html::a('Nuevo animal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_usuario',
            'nombre',
            'tipo_animal',
            'raza',
            //'descripcion',
            //'edad',
            //'sexo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
