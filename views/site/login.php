<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Iniciar sesión';
$this->params['breadcrumbs'][] = $this->title;

$js = <<<EOT

    //
    // function getLocation(){
    //     if(navigator.geolocation) {
    //         navigator.geolocation.getCurrentPosition(obtenerPosicion, errorPosicion);
    //     }else{
    //         alert("quillo esto hace falta");
    //     }
    // }
    //
    // function errorPosicion(){
    //     alert('Es necesario que permitas el acceso al localizador para que la aplicacion funcione correctamente, por favor, recarga la pagina y acepta los permisos.')
    // }
    //
    // function obtenerPosicion(position) {
    //     if(position != null){
    //         $('#login-posy').attr('value', position.coords.latitude);
    //         $('#login-posx').attr('value', position.coords.longitude);
    //         $('.btn-success').submit();
    //
    //     }else{
    //         console.log(position);
    //     }
    // }
    //
    // $('#login').on('click', function(e){
    //     e.preventDefault();
    //     getLocation();
    // })

EOT;

$this->registerJs($js);
?>
<div align="center" class="site-login ">

    <h1><?= Html::img('/imgpro/phergeon.png', ['class' => 'loginIcon img-circle'])?><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            // 'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            // 'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <!-- <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?> -->



        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Iniciar sesión', ['class' => 'btn btn-primary', 'name' => 'login-button', 'id' => 'login']) ?>

                <?= Html::a('¡Registrate!', ['usuarios/create'], ['class' => 'btn btn-success']) ?>
                <!-- <?= Html::a('Continuar como invitado', ['site/index'], ['class' => 'btn btn-success']) ?> -->
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
