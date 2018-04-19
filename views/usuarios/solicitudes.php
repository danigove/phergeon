<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Solicitudes de ' . $model->nombre_usuario;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitudes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <p>
        <?= Html::a('Create Usuarios', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_solicitud',
        'summary' => '',
    ]) ?>
</div>
