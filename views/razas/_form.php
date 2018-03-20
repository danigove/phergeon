<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Razas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="razas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tipo_animal')->textInput() ?>

    <?= $form->field($model, 'denominacion_raza')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
