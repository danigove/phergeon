<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Perfil de ' . $model->nombre_usuario;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if($_GET['id'] == Yii::$app->user->id): ?>
        <?= Html::a('Actualizar perfil', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Darte de baja', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Seguro que quieres darte de baja de la plataforma?
                                  Recuerda que los animales que has subido a la plataforma también se borrarán.',
                    'method' => 'post',
                ],
            ]) ?>
        <?php else: ?>
        <?= '' ?>
        <?php endif ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre_usuario',
            'nombre_real',
            'email:email',
            'password',
            'created_at',
            'sesskey',
            'token_val',
            [
                'attribute' => 'rol',
                'value' => $model->rol0->denominacion,
            ],
            [
                'attribute' => 'foto',
                'value' => $model->rutaImagen,
                'format' => 'image',
            ],
        ],
    ]) ?>

</div>
