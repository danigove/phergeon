<?php
use yii\helpers\Html;

$css = <<<EOT
div img {
    max-width : 100%;
}
EOT;

$this->registerCss($css);

?>
<div class='panel panel-primary panel-animal col-lg-4 col-md-4 col-xs-6'>

    <div class='panel-heading col-md-12 col-cs-12'>
        <span><?= $model->nombre ?></span>
    </div>
    <div class="borde">

        <div class='panel-body'>
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <img class="imAnimal" src="<?=$model->rutaImagen?>"/>
                </div>
                <div class="col-md-8 col-xs-12 cuerAni">
                    <p>
                        <?= $model->raza0->denominacion_raza ?>
                    </p>
                    <p>
                        <?= $model->edad > 0 ? $model->edad . ' años.' : 'Menos de un año.'  ?>
                    </p>
                    <p>
                        <?= Html::encode(substr($model->descripcion,0,27) . '...' ) ?>
                    </p>
                </div>
            </div>
        </div>
        <div class='fin-panel'>
            <span class="donante">Subido por <?=$model->usuario->nombre_usuario ?></span>
            <span >
                <?= Html::a('Ver', ['animales/view', 'id' => $model->id], ['class'=>'btn btn-primary seeAnimal']) ?>
            </span>

        </div>
    </div>
</div>
