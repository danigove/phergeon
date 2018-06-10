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
$('.field-animales-raza').on('change', function(){
    $('#errorCreate').remove();
});
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

$('#formSubmit').on('click', function(e){
    $('.errorCreate').remove();
    e.preventDefault();
    if($('#animales-raza').val() == null){
        console.log($('#animales-raza').val());
        $('.form-group:last').prepend('<div class="errorCreate"><p>Tiene que seleccionar una raza y un tipo de animal validos.</p><div>');
    }else{
        $(this).submit();
    }
})



EOT;

$this->registerJs($js);
?>

<div class="animales-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <!-- <?= $form->field($model, 'id_usuario')->textInput() ?> -->

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'foto[]')->fileInput(['multiple' => true, 'accept' => 'image/*', 'class' => "form-control-file"]) ?>

    <?php $tipos = array_merge(array('0' => 'Seleccione un tipo de animal'),$model->tipos); ?>

    <?= $form->field($model, 'tipo_animal')->dropDownList($tipos,['options' => [0 => ['selected' => 'true' ,'disabled' => true]]]) ?>

    <?= $form->field($model, 'raza')->dropDownList([]) ?>

    <?= $form->field($model, 'descripcion')->textArea(['maxlength' => 255])?>

    <?= $form->field($model, 'edad')->textInput(['type' => 'number', 'min'=>0]) ?>

    <?= $form->field($model, 'sexo')->dropDownList($model->sexosPosibles) ?>

    <div class="form-group">
        <?= Html::submitButton('Subir', ['class' => 'btn btn-success', 'id' => 'formSubmit']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
