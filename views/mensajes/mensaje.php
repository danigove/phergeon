<?php
use yii\bootstrap\Modal;

use yii\helpers\Html;

?>
<div class='panel panel-primary'>
    <div class='panel-heading'>
        <?= $model->emisor->nombre_usuario . ' : ' . $model->asunto ?>
    </div>

    <div class='panel-body'>
        <?= $model->mensaje ?>
    </div>

    <?php Modal::begin([
     'header' => '<h4>Mensaje para '. $model->emisor->nombre_usuario.'</h4>',
     'toggleButton' => ['label' => 'Responder', 'class' => 'btn btn-info botResp'],
        ]);
             echo  $this->render('_formRespuesta', [
                 'model' => $model,
             ]);
     Modal::end();
     ?>

</div>
