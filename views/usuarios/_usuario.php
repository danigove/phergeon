<?php
use yii\helpers\Html;

$css = <<<EOT
div img {
    max-width : 100%;
}
EOT;

$this->registerCss($css);

?>
<div class='panel panel-primary panel-usuario col-md-4 col-xs-6 '>
    <div class='panel-heading col-md-12 col-xs-12'>
        <span><?= $model->nombre_usuario ?></span>
    </div>
    <div class='panel-body borde'>
        <div class="row">
            <div class="col-md-12 col-xs-12 cuerAni">
                <img class="imAnimal" src="<?=$model->rutaImagen?>"/>
            </div>
        </div>
        <div>
            <?= Html::a('Ver', ['usuarios/view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>
