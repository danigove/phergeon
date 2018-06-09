<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->registerCssFile("@web/css/about.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);

$this->title = 'Sobre nosotros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about" itemscope itemtype="http://schema.org/Organization">
    <div class="row">

    <h1><?= Html::encode($this->title) ?></h1>

    <div id="prueba" class="col-md-8 col-xs-6">
            <h3><span itemprop="name">¿Qué es Phergeon?</span></h3>
                <p>
                    Phergeon es el resultado del proyecto desarrollado por
                    <a href=""><span itemprop="author">Daniel Gómez Vela</span></a> con el objetivo de poderle encontrar
                    una familia a aquellos animales que encontremos abandonados o que no nos podamos hacer más cargo de ellos.
                </p>

            <div class="col-xs-12">

            <h3>¿Cual es el propósito de Phergeon?</h3>
                <p><span itemprop="description">Esta página ha sido creada con el propósito de centralizar todos esos
                    gritos de ayuda que, por desgracia, acostumbramos a ver en distintas
                    redes sociales (Facebook, Twitter, Instagram, etc).
                    </span>
                </p>

                <p>
                    <span itemprop="description">
                        La página tambien tiene como objetivo que aquellas personas que tengan el deseo de
                        añadir un miembro más a la familia puedan tener un sitio en el que esté concentrado todos aquellos animales
                        que estén buscando a alguien que los quiera, en vez de ir buscando por distintas redes sociales, o dándote una vuelta por el pueblo/ciudad.
                    </span>
                </p>
            </div>
            </div>
                <div class="col-md-4 col-xs-6">
                    <article class="">
                        <video src="/video/adopta.mp4" type="video/mp4" controls>

                        </video>
                    </article>
                </div>
    </div>
    <h3>Objetivos de la aplicación</h3>
    <p>
        Gracias a esta aplicación web se intenta que:
        <ul>
            <li>
                Cualquier persona puedan subir aquellos animales de los que no se puede hacer cargo para encontrarles una familia lo antes posible.
            </li>
            <li>
                Las asociaciones animalistas registradas tengan una mayor facilidad para encontrar adoptantes para sus animales.
            </li>
            <li>
                Los usuarios que quieran adoptar vean qué animales se encuentran mas cerca de su posición, para evitar el transporte del animal, ya que puede causar traumas al animal.
            </li>

        </ul>
    </p>
</div>
