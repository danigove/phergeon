<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Animales */

$this->title = 'Perfil de ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Animales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$js = <<<EOT
EOT;

$this->registerJs($js);

?>
<div id="tweet-container">

</div>
<div class="animales-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <a target="_blank" href="https://twitter.com/share?url=https%3A%2F%2Fdev.twitter.com%2Fweb%2Ftweet-button
    &via=twitterdev
    &related=twitterapi%2Ctwitter
    &hashtags=<?= urlencode("pepe,obama")?>
    &text=<?= urlencode("Ayudame a encontrarle una familia a $model->nombre ");?>">
    Tweet
    </a>

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
            [
                'label' => 'Enviado por',
                'format' => 'raw',
                'value' => Html::a($model->usuario->nombre_usuario, ['usuarios/view', 'id' => $model->usuario->id]),
                // 'value' => $model->usuario->nombre_usuario,
            ],
            'nombre',
            [
                'attribute' => 'tipo_animal',
                'value' => $model->tipoAnimal->denominacion_tipo,
            ],
            [
                'attribute' => 'raza',
                'value' => $model->raza0->denominacion_raza,
            ],
            'descripcion',
            'edad',
            'sexo',
            [
                'attribute' => 'foto',
                'value' => $model->rutaImagen,
                'format' => 'image',
            ],
        ],
    ]) ?>

</div>
