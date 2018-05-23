<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ('<li>'.
            Html::beginForm(['/site/buscar'], 'get').
            Html::textInput('criterio', Yii::$app->request->get('criterio') , ['placeholder'=>'Introduzca lo que quiere buscar aquí']).
            Html::submitButton('Buscar', ['class' => 'btn btn-link logout']) .
            Html::endForm()

            .'</li>'),
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => Yii::$app->session->id, 'url' => ['#']],
            ['label' => 'Usuarios', 'url' => ['/usuarios/index']],
            ['label' => 'Animales', 'url' => ['/animales/index']],
            ['label' => 'Adopciones', 'url' => ['/adopciones/index']],
            ['label' => 'Roles', 'url' => ['/roles/index']],
            ['label' => 'Historiales', 'url' => ['/historiales/index']],
            ['label' => 'Tipos', 'url' => ['/tipos/index']],
            ['label' => 'Razas', 'url' => ['/razas/index']],
            ['label' => 'Facturas', 'url' => ['/facturas/index']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->nombre_usuario . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
