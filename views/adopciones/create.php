<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Adopciones */

$this->title = 'Create Adopciones';
$this->params['breadcrumbs'][] = ['label' => 'Adopciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adopciones-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
