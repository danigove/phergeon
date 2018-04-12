<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Animales */

$this->title = 'Perfil de ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Animales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$js = <<<EOT
    $('.twitter').on('click', function(e){
        e.preventDefault();
        console.log(e.target);
        window.open($(this).data('href'), '', 'width=700, height=500, top=400, left=500');
    });

EOT;

$this->registerJs($js);

?>
<div id="tweet-container">

</div>
<div class="animales-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <button class="twitter" data-href='https://twitter.com/share?url=https%3A%2F%2Fdev.twitter.com%2Fweb%2Ftweet-button
    &via=Phergeon
    &related=Phergeon%2Ctwitter
    &hashtags=<?= urlencode($model->etiquetasAnimal())?>
    &text=<?= urlencode("Ayudame a encontrarle una familia a $model->nombre ");?><?= $model->rutaAnimal($model->id)?>'>
    Twitter
    </button>

    <?php if(Yii::$app->user->id == $model->usuario->id): ?>
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
    <?php endif ?>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.12';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <div class="fb-share-button"
        data-href="<?= $model->rutaAnimal($model->id) ?>"
         data-layout="button"
         data-size="small"
         data-mobile-iframe="true">
            <a target="_blank"
               href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse"
               class="fb-xfbml-parse-ignore">
               Compartir
           </a>
    </div>
    <!-- <?= $model->rutaAnimal($model->id) ?> -->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Enviado por',
                'format' => 'raw',
                'value' => Html::a($model->usuario->nombre_usuario, ['usuarios/view', 'id' => $model->usuario->id]),
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
