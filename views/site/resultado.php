<?php

/* @var $this yii\web\View */

use yii\widgets\ListView;
use yii\helpers\Html;

$this->title = 'Resultados de la búsqueda';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

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
                'summary' => 'Usuarios',
            ]); ?>
        <?php endif?>
    </p>
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
                'summary' => 'Animales',
            ]); ?>
        <?php endif?>
    </p>
</div>
