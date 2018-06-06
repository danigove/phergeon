<?php
use yii\bootstrap\Modal;

use yii\helpers\Html;

?>
<div class='panel panel-success'>
    <div class='panel-heading'>
        <?= $model->emisor->nombre_usuario . ' : ' . $model->asunto ?>
    </div>

    <div class='panel-body'>
        <?= $model->mensaje ?>
    </div>

    <div>
    <?php Modal::begin([
     'header' => '<h4>Mensaje para '. $model->emisor->nombre_usuario.'</h4>',
     'toggleButton' => ['label' => 'Responder', 'class' => 'btn btn-info botResp'],
        ]);
             echo  $this->render('_formRespuesta', [
                 'model' => $model,
             ]);
     Modal::end();
     ?>
         <?php if($model->receptor->id == Yii::$app->user->id || $model->emisor->id == Yii::$app->user->id): ?>
             <?= Html::a('Ignorar', ['delete', 'id' => $model->id], [
                 'class' => 'btn btn-danger botResp',
                 'data' => [
                     'confirm' => '¿Ignorar mensaje?',
                     'method' => 'post',
                 ],
             ]) ?>

         <?php endif ?>

     </div>

</div>
