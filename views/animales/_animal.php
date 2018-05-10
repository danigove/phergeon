<?php
use yii\helpers\Html;

$css = <<<EOT
div img {
    width : 25%;
}
EOT;

$this->registerCss($css);

?>
<div class='panel panel-primary'>
    <div class='panel-heading'>
        <span><?= $model->nombre ?></span>
    </div>

    <div class='panel-body'>
        <img src="<?=$model->rutaImagen?>"/>
        <span><?= $model->distancia() ?></span>
    </div>
    <div>
        <span>Subido por <?=$model->usuario->nombre_usuario ?></span>
        <?= Html::a('Ver', ['animales/view', 'id' => $model->id]) ?>

    </div>
</div>
