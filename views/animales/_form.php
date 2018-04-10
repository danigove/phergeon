<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Animales */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="animales-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'id_usuario')->textInput() ?> -->

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'tipo_animal')->textInput() ?>

    <?= $form->field($model, 'raza')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'edad')->textInput(['type' => 'number', 'min'=>0]) ?>

    <?= $form->field($model, 'sexo')->dropDownList($model->sexosPosibles) ?>

    <?= $form->field($model, 'foto')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
