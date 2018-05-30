<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
// $url = Url::to(['razas/razasion']);
$js = <<<EOT


    function getLocation(){
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(obtenerPosicion, errorPosicion);
        }else{
            alert("quillo esto hace falta");
        }
    }

    function errorPosicion(){
        alert('Es necesario que permitas el acceso al localizador para que la aplicacion funcione correctamente, por favor, recarga la pagina y acepta los permisos.')
    }

    function obtenerPosicion(position) {
        if(position != null){
            $('#usuarios-posy').attr('value', position.coords.latitude);
            $('#usuarios-posx').attr('value', position.coords.longitude);
            $('.btn-success').submit();

        }else{
            console.log(position);
        }
    }

    $('.btn-success').on('click', function(e){
        e.preventDefault();
        getLocation();
    })

EOT;

$this->registerJs($js);

?>
<div id="demo">
</div>
<div class="usuarios-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'nombre_usuario')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'nombre_real')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        </div>

    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'foto')->fileInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
        </div>

    </div>
    
    <?= $form->field($model, 'posx')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'posy')->hiddenInput(['maxlength' => true])->label(false) ?>


    <!-- <?= $form->field($model, 'created_at')->textInput() ?> -->

    <!-- <?= $form->field($model, 'sesskey')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'token_val')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'rol')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
