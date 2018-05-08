<?php

?>
<div class='panel panel-primary'>
    <div class='panel-heading'>
        <span><?= $model->nombre ?></span>
    </div>

    <div class='panel-body'>
        <span><?= $model->distancia() ?></span>
    </div>
    <div>
        <span>Subido por <?=$model->usuario->nombre_usuario ?></span>
    </div>
</div>
