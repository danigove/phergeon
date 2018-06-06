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


    <div class="row">

        <div class="col-md-4">
            <?=Html::img($model->foto , ['class'=>'fotoUsuario img-circle']);?>
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
                    <?php if($model->rol0->id != 2): ?>
                        <?= Html::a('Autentícate', ['site/autenticar'], ['class' => 'btn btn-success']) ?>
                    <?php endif ?>
                <?php else: ?>
                <?= '' ?>
                <?php endif ?>

            </p>
        </div>
        <div class="col-md-8">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    // 'id',
                    'nombre_usuario',
                    'nombre_real',
                    'email:email',
                    // 'password',
                    // 'created_at',
                    // 'foto',
                    // 'token_val',
                    // 'posx',
                    // 'posy',
                    [
                        'attribute' => 'rol',
                        'value' => $model->rol0->denominacion,
                    ],
                ],
            ]) ?>
        </div>


    </div>
</div>

<?php if(count($animales) > 0): ?>
    <div class="cabecera">
        <h3>Animales disponibles de este usuario</h3>
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
