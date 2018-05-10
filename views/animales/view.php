<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\detail\DetailView;

// use yii\widgets\DetailView;
// use yii\helpers\Url;

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


if(!Yii::$app->user->isGuest){

    $js = <<<EOT

        $.ajax({
            url:'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=40.6655101,-73.89188969999998&destinations=40.6905615%2C-73.9976592%7C40.6905615%2C-73.9976592%7C40.6905615%2C-73.9976592%7C40.6905615%2C-73.9976592%7C40.6905615%2C-73.9976592%7C40.6905615%2C-73.9976592%7C40.659569%2C-73.933783%7C40.729029%2C-73.851524%7C40.6860072%2C-73.6334271%7C40.598566%2C-73.7527626%7C40.659569%2C-73.933783%7C40.729029%2C-73.851524%7C40.6860072%2C-73.6334271%7C40.598566%2C-73.7527626&key=AIzaSyDFbHuskLMwZpQLzAltPFzS_XgJffOHcOs',
            method: 'POST',
            dataType: 'json',
            success: function(data){
                console.log(data);
            },
            error: function(error){
                console.log(error);
            }
        });

EOT;

    $this->registerJs($js);
}
else {

    $js = <<<EOT

        alert('No porque vas de guest');
EOT;

    $this->registerJs($js);

}

?>
<div id="tweet-container">

</div>
<div class="animales-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <!-- <?= $model->rutaAnimal($model->id) ?> -->
<!--
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
    ]) ?> -->


    <?php
    echo DetailView::widget([
    'model'=>$model,
    'condensed'=>false,
    'responsive' => true,
    'hover'=>true,
    'mode'=>DetailView::MODE_VIEW,
    'attributes'=>[
       [
           'group'=>true,
           'label'=>'Información general del animal',
           'rowOptions'=>['class'=>'info']
       ],
       [
           'columns' => [
               [
                   'attribute' => 'foto',
                   'value' => $model->rutaImagen,
                   'format' => 'image',
               ],
                   'nombre',

           ],
       ],
       'descripcion',
        [
            'label' => 'Enviado por',
            'format' => 'raw',
            'value' => Html::a($model->usuario->nombre_usuario, ['usuarios/view', 'id' => $model->usuario->id]),
        ],
        [
            'attribute' => 'tipo_animal',
            'value' => $model->tipoAnimal->denominacion_tipo,
        ],
        [
            'attribute' => 'raza',
            'value' => $model->raza0->denominacion_raza,
        ],
        [
            'label' => 'Edad',
            'value' => $model->edad . ' años.',
        ],
        [
            'label' => 'Distancia por metodo',
            'value' => $model->distancia() . ' kms.',
        ],
        'distancia',

    ]
    ]);

    ?>

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

    <p>
        <h3>Operaciones:</h3>
        <button class="twitter" data-href='https://twitter.com/share?url=https%3A%2F%2Fdev.twitter.com%2Fweb%2Ftweet-button
        &via=Phergeon
        &related=Phergeon%2Ctwitter
        &hashtags=<?= urlencode($model->etiquetasAnimal())?>
        &text=<?= urlencode("Ayudame a encontrarle una familia a $model->nombre ") .  urlencode($model->rutaAnimal($model->id))?>'>
        Twitter
        </button>
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
        <!-- <?= Html::a('Adóptame', ['adopciones/create'], ['class' => 'btn btn-primary']) ?> -->
        <div>
            <?php $form = ActiveForm::begin([
             'id' => 'solicitar-adopcion-form',
             'method' => 'post',
             'action' => ['adopciones/solicitar'],
             ])
             ?>
             <?= $form->field($solicitarAdopcionForm, 'id_donante')->hiddenInput(['value'=> $model->id_usuario])->label(false) ?>
             <?= $form->field($solicitarAdopcionForm, 'id_animal')->hiddenInput(['value'=> $model->id])->label(false) ?>
             <div class="form-group">
                 <?= Html::submitButton($model->estaSolicitado($model->id) ? 'Ya has solicitado este animal' : 'Adóptame', ['class' => 'btn btn-success']) ?>
             </div>
         <?php ActiveForm::end() ?>


        </div>
    </p>
</div>
