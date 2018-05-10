<?php

/* @var $this yii\web\View */

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
        This is the About page. You may modify the following file to customize its content:
    </p>
</div>
