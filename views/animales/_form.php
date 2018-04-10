<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Animales */
/* @var $form yii\widgets\ActiveForm */

$url = Url::to('razas/razasAjax');
$js = <<<EOT
$('#animales-tipo_animal').on('change', function(){
    $.ajax({
        url: '$url',
        type: 'POST',
        dataType: 'json',
        data: $('#animales-tipo_animal').val(),
        success: function(data){
            console.log(data);
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

    <?= $form->field($model, 'raza')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'edad')->textInput(['type' => 'number', 'min'=>0]) ?>

    <?= $form->field($model, 'sexo')->dropDownList($model->sexosPosibles) ?>

    <div class="form-group">
        <?= Html::submitButton('Subir', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
