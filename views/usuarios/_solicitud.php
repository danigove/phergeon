<?php

use yii\helpers\Html;

?>
<div class='panel panel-primary'>
    <div class='panel-heading'>
        <?= 'Nueva solicitud de adopción para ' . $model->animal->nombre ?>
        <span align='right'>
            <?= 'Por: ' . $model->usuarioAdoptante->nombre_usuario ?>
        </span>
    </div>

    <div class='panel-body'>
        <?= $model->animal->descripcion ?>
    </div>
    <div>
        <?= Html::a('Aprobar la adopción', ['adopciones/aprobar', 'id' => $model->id], ['data-method' => 'POST', 'class' => 'btn btn-success']) ?>
        <?= Html::a('Denegar solicitud', ['adopciones/delete', 'id' => $model->id], ['data-method' => 'POST', 'class' => 'btn btn-danger']) ?>
    </div>
</div>
