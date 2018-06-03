<?php

/* @var $this yii\web\View */

use yii\widgets\ListView;
use yii\helpers\Html;

$this->title = 'Resultados de la búsqueda';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <div class="row">

            <h1><?= Html::encode($this->title) ?></h1>
            <div>
                <p>
                    <?php if ($string != ''):?>
                        <p>
                            Resultados de la búsqueda con <?= $string ?>
                        </p>
                    <?php endif ?>
                    <?php if(count($dataProviderAso)>0): ?>
                        <?= ListView::widget([
                            'dataProvider' => $dataProviderAso,
                            'itemView' => '../usuarios/_usuario',
                            'summary' => '<h3 class="resultado-usuarios">Usuarios con coincidencias</h3>',
                        ]); ?>
                    <?php endif?>
                </p>
            </div>
        </div>
        <div class="row">
            <div>
                <p>
                    <?php if ($string != ''):?>
                        <p>
                            Resultados de la búsqueda con <?= $string ?>
                        </p>
                    <?php endif ?>
                    <?php if(count($dataProviderAso)>0): ?>
                        <?= ListView::widget([
                            'dataProvider' => $dataProviderAni,
                            'itemView' => '../animales/_animal',
                            'summary' => '<h3 class="resultado-animales">Animales con coincidencias</h3>',
                        ]); ?>
                    <?php endif?>
                </p>
            </div>
        </div>
    </div>
</div>
