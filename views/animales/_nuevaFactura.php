<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Facturas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="facturas-form">

    <?php $form = ActiveForm::begin(['action' =>['facturas/create']]); ?>

    <!-- <?= $form->field($model, 'id_animal')->textInput() ?> -->
    <?= $form->field($model, 'id_animal')->hiddenInput(['value'=> $id_animal])->label(false) ?>

    <!-- <?= $form->field($model, 'fecha_emision')->textInput() ?> -->

    <?= $form->field($model, 'centro_veterinario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'importe')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Añadir factura', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
