<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Historiales */

$this->title = 'Create Historiales';
$this->params['breadcrumbs'][] = ['label' => 'Historiales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historiales-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
