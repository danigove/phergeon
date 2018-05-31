<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

$this->registerJsFile(
    '@web/js/password_strength_lightweight.js',
    ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]
);


$this->registerCssFile("@web/css/password_strength.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);

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
    });

    $('#myPassword').strength_meter({
          //  CSS selectors
     strengthWrapperClass: 'strength_wrapper',
     // inputClass: 'strength_input',
     strengthMeterClass: 'strength_meter',
      // toggleButtonClass: 'button_strength',

      // text for show / hide password links
     // showPasswordText: 'Show Password',
     // hidePasswordText: 'Hide Password'

    });



EOT;


$this->registerJs($js);



$css = <<<EOT
// #myPassword div:not {
//     display: none !important;
// }
.strength_input, .button_strength{
    display:none;
    height: 0px;
    width: 0px;
}
EOT;

$this->registerCss($css);
?>
<div id="demo">
</div>
<div class="usuarios-form">
    <?php $form = ActiveForm::begin(
        ['id' => 'registration-form']
    ); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'nombre_usuario', ['enableAjaxValidation' => true])->textInput(['maxlength' => true]) ?>

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
        <div  id="myPassword" class="col-md-4">
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
