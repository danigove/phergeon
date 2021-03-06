<?php
use yii\bootstrap\Modal;

use yii\helpers\Html;

?>
<div class='panel panel-success'>
    <div class='panel-heading'>
        <?php if($model->emisor->nombre_usuario===Yii::$app->user->identity->nombre_usuario):?>
            <?= 'Este es un mensaje es tuyo para ' . $model->receptor->nombre_usuario   ?>
        <?php else: ?>
            <?= $model->emisor->nombre_usuario . ' : ' . $model->asunto ?>
        <?php endif ?>
    </div>

    <div class='panel-body'>
        <?= $model->mensaje ?>
    </div>

    <div>
        <?php if($model->emisor->id != Yii::$app->user->id): ?>
            <?php Modal::begin([
             'header' => '<h4>Mensaje para '. $model->emisor->nombre_usuario.'</h4>',
             'toggleButton' => ['label' => 'Responder', 'class' => 'btn btn-info botResp'],
                ]);
                     echo  $this->render('_formRespuesta', [
                         'model' => $model,
                     ]);
             Modal::end();
             ?>
        <?php endif ?>
             <?php if($model->receptor->id == Yii::$app->user->id || $model->emisor->id == Yii::$app->user->id): ?>
                 <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
                     'class' => 'btn btn-danger botResp',
                     'data' => [
                         'confirm' => '¿Borrar mensaje?',
                         'method' => 'post',
                     ],
                 ]) ?>

             <?php endif ?>

     </div>

</div>
