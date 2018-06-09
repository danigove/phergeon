<?php
use yii\helpers\Html;

$css = <<<EOT
div img {
    max-width : 100%;
}
EOT;

$this->registerCss($css);

?>
<div class='panel panel-primary panel-usuario col-md-4 col-xs-6'>
    <div class='panel-heading'>
        <span><?= $model->nombre_usuario ?></span>
    </div>

    <div class='panel-body'>
        <img src="<?=$model->rutaImagen?>"/>
    </div>
    <div>
        <?= Html::a('Ver', ['usuarios/view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </div>
</div>
