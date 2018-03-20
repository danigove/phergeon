<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Adopciones */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Adopciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adopciones-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_usuario_donante',
            'id_usuario_adoptante',
            'id_animal',
            'fecha_adopcion',
        ],
    ]) ?>

</div>
