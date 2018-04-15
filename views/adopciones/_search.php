<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdopcionesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adopciones-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_usuario_donante') ?>

    <?= $form->field($model, 'id_usuario_adoptante') ?>

    <?= $form->field($model, 'id_animal') ?>

    <?= $form->field($model, 'aprobado')->checkbox() ?>

    <?php // echo $form->field($model, 'fecha_adopcion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
