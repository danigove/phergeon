<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Adopciones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adopciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_usuario_donante')->textInput() ?>

    <?= $form->field($model, 'id_usuario_adoptante')->textInput() ?>

    <?= $form->field($model, 'id_animal')->textInput() ?>

    <?= $form->field($model, 'fecha_adopcion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
