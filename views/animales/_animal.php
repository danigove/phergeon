<?php
use yii\helpers\Html;

$css = <<<EOT
div img {
    max-width : 25%;
}
EOT;

$this->registerCss($css);

?>
<div class='panel panel-primary panel-animal'>
    <div class='panel-heading'>
        <span><?= $model->nombre ?></span>
    </div>

    <div class='panel-body'>
        <div class="row">
            <div class="col-md-4">
                <img src="<?=$model->rutaImagen?>"/>
            </div>
            <div class="col-md-8">
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


        <!-- <?php if(!Yii::$app->user->isGuest): ?>
        <span><?= $model->distancia() ?></span>
    <?php else: ?>
        <span><?= $model->usuario->rol ?></span>
        <?php endif ?> -->
    </div>
    <div class='fin-panel'>
        <span class="donante">Subido por <?=$model->usuario->nombre_usuario ?></span>
        <span >
            <?= Html::a('Ver', ['animales/view', 'id' => $model->id], ['class'=>'btn btn-primary seeAnimal']) ?>
        </span>

    </div>
</div>
