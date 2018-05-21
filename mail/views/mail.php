<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>
<h2>Bienvenido, <?= $nombre ?></h2>
<p>
    Para terminar de validar necesitamos que le des al siguiente enlace:
</p>
<a href="<?= $enlaceAutenticacion ?>">Pulse en este enlace para autenticarse.</a>
<p>
    Una vez terminado su cuenta ya funcionará como una asociación animalista, con todas sus correspondientes ventajas.
    Un cordial saludo.
</p>
<p>
    Phergeon
</p>
<?= Html::a('Ir a página principal', Url::home('http')) ?>
