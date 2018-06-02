<?php
use yii\helpers\Html;

$css = <<<EOT
div img {
    max-width : 100%;
}
EOT;

$this->registerCss($css);

?>
<div class='panel panel-primary panel-usuario'>
    <div class='panel-heading'>
        <span><?= $model->nombre_usuario ?></span>
    </div>

    <div class='panel-body'>
        <img src="<?=$model->rutaImagen?>"/>
    </div>
    <div>
        <span>Subido por <?=$model->nombre_usuario ?></span>
        <?= Html::a('Ver', ['usuarios/view', 'id' => $model->id]) ?>

    </div>
</div>
