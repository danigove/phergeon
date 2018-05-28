<?php

use app\models\Animales;

use yii\data\Pagination;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;

use yii\widgets\ListView;

/* @var $this yii\web\View */

$this->title = '';
?>
<div class="site-index">
    <h2>Bienvenido a Phergeon</h2>
    <div class="body-content">

        <h1><?= Html::encode($this->title) ?></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php if(!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Nuevo animal', ['animales/create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?php endif?>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '../animales/_animal',
        ]); ?>

    </div>
</div>
