<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FacturasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="facturas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_animal') ?>

    <?= $form->field($model, 'fecha_emision') ?>

    <?= $form->field($model, 'centro_veterinario') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'importe') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
