<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;


/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Perfil de ' . $model->nombre_usuario;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$css = <<<EOT
    #animalesUsuario div div{
        display: none;
    }
EOT;

$this->registerCss($css);

$js = <<<EOT

    $('#mostrarAni').on('click', function(e){
        e.preventDefault();
        $('#animalesUsuario div div').fadeToggle(600);
    });


EOT;

$this->registerJs($js);



?>
<div class="usuarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if($_GET['id'] == Yii::$app->user->id): ?>
        <?= Html::a('Actualizar perfil', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Darte de baja', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Seguro que quieres darte de baja de la plataforma?
                                  Recuerda que los animales que has subido a la plataforma también se borrarán.',
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a('Autentícate', ['site/autenticar'], ['class' => 'btn btn-success']) ?>
            <?php if($model->getNumSolicitudes($model->id) >= 0) : ?>
                <?= Html::a('Tienes ' . $model->getNumSolicitudes($model->id) . ' solicitudes de adopcion pendientes.', ['solicitudes', 'id' => $model->id], ['class' => 'btn info']) ?>
            <?php else: ?>
                <?= '<span>No tienes solicitudes ahora mismo.</span>' ?>
            <?php endif ?>
        <?php else: ?>
        <?= '' ?>
        <?php endif ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre_usuario',
            'nombre_real',
            'email:email',
            'password',
            'created_at',
            'sesskey',
            'token_val',
            'posx',
            'posy',
            [
                'attribute' => 'rol',
                'value' => $model->rol0->denominacion,
            ],
            [
                'attribute' => 'foto',
                'value' => $model->rutaImagen,
                'format' => 'image',
            ],
        ],
    ]) ?>

</div>

<?php if(count($animales) > 0): ?>
    <div class="cabecera">
        <h3>Animales que tiene o ha tenido el usuario.</h3>
    </div>
    <?= Html::a('Mostrar','',['id' => 'mostrarAni', 'class' => 'btn btn-primary']) ?>
    <div id="animalesUsuario">
        <?= ListView::widget([
            'dataProvider' => $animales,
            'itemView' => '../animales/_animal',
            'summary' => '',
        ]); ?>
    </div>
<?php else: ?>
    <div class="cabecera">
        <h3>El usuario aún no ha subido ningún animal.</h3>
    </div><?php endif ?>
