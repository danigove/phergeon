<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Animales */
/* @var $form yii\widgets\ActiveForm */

$js = <<<EOT






EOT;

$this->registerJs($js);
?>

<div class="animales-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'id_usuario')->textInput() ?> -->

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'foto')->fileInput() ?>

    <?= $form->field($model, 'tipo_animal')->dropDownList($model->tipos) ?>

    <?= $form->field($model, 'raza')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'edad')->textInput(['type' => 'number', 'min'=>0]) ?>

    <?= $form->field($model, 'sexo')->dropDownList($model->sexosPosibles) ?>

    <div class="form-group">
        <?= Html::submitButton('Subir', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
