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
$this->title = Yii::$app->name;
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
<?php $this->registerJsFile(
    '/js/comun.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('/imgpro/phergeon.png', ['class' => 'logoIcon']),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top cabecera',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ('<li>'.
            Html::beginForm(['/site/buscar'], 'get', ['id' => 'formBusqueda']).
            Html::textInput('criterio', Yii::$app->request->get('criterio') , ['placeholder'=>'Busque aquí', 'id' => 'inputBusqueda']).
            Html::submitButton('Buscar', ['class' => 'btn btn-link logout']) .
            Html::endForm()

            .'</li>'),
            ['label' => 'Inicio', 'url' => ['/site/index']],
            ['label' => 'Usuarios', 'url' => ['/usuarios/index']],
            ['label' => 'Animales', 'url' => ['/animales/index']],
            ['label' => 'Sobre nosotros', 'url' => ['/site/about']],
            Yii::$app->user->isGuest ? '' : ['label' => 'Mi perfil', 'url' => ['/usuarios/view', 'id'=> Yii::$app->user->identity->id]],
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
        <p class="pull-left">&copy; <?=Yii::$app->name?> <?= date('Y') ?></p>

        <p class="pull-right">Desarrollado por
                <a href="https://github.com/danigove" target="_blank" >Daniel Gómez Vela</a>
                <img class="logoGit" src="/imgpro/github.png"/>
        </p>

    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
