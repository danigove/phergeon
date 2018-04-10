<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Animales */
/* @var $form yii\widgets\ActiveForm */

$url = Url::to(['razas/razasion']);
$js = <<<EOT
$('.field-animales-raza').hide();
$('#animales-tipo_animal').on('change', function(){
    $.ajax({
        url: "$url",
        type: 'POST',
        dataType: 'json',
        data: {tipo: $('#animales-tipo_animal').val()},
        success: function(data){
            var longitud = Object.keys(data);
            $('#animales-raza').empty();
            $('.field-animales-raza').show();
            for(i = 0; i < longitud.length; i++){
                console.log(longitud[i] + ' - ' +data[longitud[i]]);
                $('#animales-raza').append('<option value="'+longitud[i]+'">' + data[longitud[i]] +' </option>');
            }



        },
        error: function(error){
            console.log(error);
        }
    });


});




EOT;

$this->registerJs($js);
?>

<div class="animales-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'id_usuario')->textInput() ?> -->

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'foto')->fileInput() ?>

    <?= $form->field($model, 'tipo_animal')->dropDownList($model->tipos) ?>

    <?= $form->field($model, 'raza')->dropDownList($model->tipos) ?>

    <?= $form->field($model, 'descripcion')?>

    <?= $form->field($model, 'edad')->textInput(['type' => 'number', 'min'=>0]) ?>

    <?= $form->field($model, 'sexo')->dropDownList($model->sexosPosibles) ?>

    <div class="form-group">
        <?= Html::submitButton('Subir', ['class' => 'btn btn-success']) ?>
    </div>
    <?= Html::a('¡Registrate!', ['razas/razasion'], ['class' => 'btn btn-success']) ?>

    <?php ActiveForm::end(); ?>

</div>
