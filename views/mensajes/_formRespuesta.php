<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Mensajes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mensajes-form">

    <?php $form = ActiveForm::begin(['action' => Url::to(['mensajes/create'])]); ?>

    <?= $form->field($model, 'id_receptor')->hiddenInput(['value' => $model->emisor->id])->label(false) ?>

    <!-- <?= $form->field($model, 'id_emisor')->textInput() ?> -->

    <?= $form->field($model, 'asunto')->textInput(['maxlength' => true, 'value' => '(RE) Preguntando por ' . $model->asunto, 'readonly' => 'readonly']) ?>

    <?= $form->field($model, 'mensaje')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
