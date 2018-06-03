<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\detail\DetailView;
use yii\grid\GridView;


// use yii\widgets\DetailView;
// use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Animales */

$this->title = 'Perfil de ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Animales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$css = <<<EOT
    #facturasAnimal div div{
        // display: none;
    }
    #right-panel {
          font-family: 'Roboto','sans-serif';
          line-height: 30px;
          padding-left: 10px;
        }

        #right-panel select, #right-panel input {
          font-size: 15px;
        }

        #right-panel select {
          width: 100%;
        }

        #right-panel i {
          font-size: 12px;
        }
        html, body {
          height: 100%;
          margin: 0;
          padding: 0;
        }
        #map {
          height: 30em;
          width: 50%;
        }
        #right-panel {
          float: right;
          width: 48%;
          padding-left: 2%;
        }
        #output {
          font-size: 11px;
        }

EOT;

$this->registerCss($css);

$js = <<<EOT
    $('#mostrarFac').on('click', function(e){
        e.preventDefault();
        $('#facturasAnimal div div').fadeToggle(600);
        if($(this).text() === 'Ocultar formulario'){
            $(this).text('Añadir nueva factura');
        }else{
            $(this).text('Ocultar formulario');
        }
    });



    $('.twitter').on('click', function(e){
        e.preventDefault();
        console.log(e.target);
        window.open($(this).data('href'), '', 'width=700, height=500, top=400, left=500');
    });

EOT;

$this->registerJs($js);


if(!Yii::$app->user->isGuest){

    $js = <<<EOT


EOT;

    $this->registerJs($js);
}

?>
<div id="tweet-container">

</div>
<div class="animales-view">

    <h1  id=""><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-4">

            <div id="myCarousel" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
              </ol>

              <!-- Wrapper for slides -->
              <div class="carousel-inner">

                <?php if(count($fotos) == 0): ?>
                    <div class="item active">
                      <img src="<?=$model->rutaImagen?>" alt="">
                    </div>
                <?php else : ?>
                <?php for($i = 0 ; $i < count($fotos); $i++): ?>
                    <div class="item <?= $i == 0 ? 'active' : '' ?>">
                     <img src="<?=$fotos[$i]->link?>" alt="">
                    </div>
                    <?php endfor ?>
                <?php endif ?>

                <!-- <div class="item">
                  <img src="<?=$model->rutaImagen?>" alt="New York">
                </div> -->
              </div>

              <!-- Left and right controls -->
              <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
        </div>
        <div class="col-md-8">
            <?php
            echo DetailView::widget([
            'model'=>$model,
            'condensed'=>false,
            'responsive' => true,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'attributes'=>[
               [
                   'group'=>true,
                   'label'=>'Información general del animal',
                   'rowOptions'=>['class'=>'info']
               ],
               'nombre',
               'descripcion',
                [
                    'label' => 'Enviado por',
                    'format' => 'raw',
                    'value' => Html::a($model->usuario->nombre_usuario, ['usuarios/view', 'id' => $model->usuario->id]),
                ],
                [
                    'attribute' => 'tipo_animal',
                    'value' => $model->tipoAnimal->denominacion_tipo,
                ],
                [
                    'attribute' => 'raza',
                    'value' => $model->raza0->denominacion_raza,
                ],
                [
                    'label' => 'Edad',
                    'value' => $model->edad . ' años.',
                ],
                [
                    'label' => 'Origen del interesado / destino',
                    'format' => 'raw',
                    'value' => '<span id="cabecera"></span>',
                ],
            ]
            ]);

            ?>

        </div>
    </div>



    <?php if(Yii::$app->user->id == $model->usuario->id): ?>
        <p>
            <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Seguro que quieres borrar al animal?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif ?>

    <p>
        <h3>Operaciones:</h3>
        <div class="button-group">

        <button class="twitter" data-href='https://twitter.com/share?url=https%3A%2F%2Fdev.twitter.com%2Fweb%2Ftweet-button
        &via=Phergeon
        &related=Phergeon%2Ctwitter
        &hashtags=<?= urlencode($model->etiquetasAnimal())?>
        &text=<?= urlencode("Ayudame a encontrarle una familia a $model->nombre ") .  urlencode($model->rutaAnimal($model->id))?>'>
        <span class="icon icon-twitter"></span><span> Twitter</span>
        </button>

        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.12';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <div class="fb-share-button"
            data-href="<?= $model->rutaAnimal($model->id) ?>"
             data-layout="button"
             data-size="large"
             data-mobile-iframe="true">
                <a target="_blank"
                   href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse"
                   class="fb-xfbml-parse-ignore">
                   Compartir
               </a>
        </div>
        <!-- <?= Html::a('Adóptame', ['adopciones/create'], ['class' => 'btn btn-primary']) ?> -->
        <div>
            <?php $form = ActiveForm::begin([
             'id' => 'solicitar-adopcion-form',
             'method' => 'post',
             'action' => ['adopciones/solicitar'],
             ])
             ?>
             <?= $form->field($solicitarAdopcionForm, 'id_donante')->hiddenInput(['value'=> $model->id_usuario])->label(false) ?>
             <?= $form->field($solicitarAdopcionForm, 'id_animal')->hiddenInput(['value'=> $model->id])->label(false) ?>
             <div class="form-group">
                 <?= Html::submitButton($model->estaSolicitado($model->id) ? 'Ya has solicitado este animal' : 'Adóptame', ['class' => 'btn btn-success']) ?>
             </div>
         <?php ActiveForm::end() ?>


        </div>
    </p>
</div>
</div>


<div class="cabecera">
    <h3>Facturas que tiene el animal asociadas</h3>
</div>



<?= GridView::widget([
    'dataProvider' => $facturas,
    'columns' => [
        // ['class' => 'yii\grid\SerialColumn'],
        // 'id',
        // 'id_animal',
        'fecha_emision',
        'centro_veterinario',
        'descripcion',
        'importe',

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model, $key){
                    if (!Yii::$app->user->isGuest &&
                        ($model->animal->usuario->id == Yii::$app->user->identity->id)) {
                        return Html::a('', ['facturas/delete', 'id' => $model->id], [
                            'class' => 'glyphicon glyphicon-trash',
                            'data' => [
                                'confirm' => '¿Estás seguro que quieres borrar este envio?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                },
            ],
        ],
    ],
]); ?>

<?php if(!(Yii::$app->user->isGuest) && $model->usuario->id === Yii::$app->user->identity->id): ?>

<?= Html::a('Añadir nueva factura','',['id' => 'mostrarFac', 'class' => 'btn btn-primary']) ?>
<div id="facturasAnimal">

    <?= $this->render('_nuevaFactura', [
        'id_animal' => $model->id,
        'model' => $facturaNueva,
    ]) ?>

</div>

<?php endif ?>
<div id="right-panel">
     <!-- <div id="inputs">
       <pre>
var origin1 = {lat: 55.930, lng: -3.118};
var origin2 = 'Greenwich, England';
var destinationA = 'Stockholm, Sweden';
var destinationB = {lat: 50.087, lng: 14.421};
       </pre>
     </div>
     <div>
       <strong>Results</strong>
     </div> -->
     <div id="output"></div>
   </div>
   <div id="map"></div>
   <?php if(!Yii::$app->user->isGuest):
       // var_dump($model->usuario->posy) ; die();
       ?>
   <script>
     function initMap() {
       var bounds = new google.maps.LatLngBounds;
       var markersArray = [];

       var origin1 = {lat: <?= Yii::$app->user->identity->posx ?>, lng: <?= Yii::$app->user->identity->posy ?> };
       var destinationA = {lat: <?= $model->usuario->posx ?>, lng: <?= $model->usuario->posy ?> };

       var destinationIcon = 'https://chart.googleapis.com/chart?' +
           'chst=d_map_pin_letter&chld=D|FF0000|000000';
       var originIcon = 'https://chart.googleapis.com/chart?' +
           'chst=d_map_pin_letter&chld=O|FFFF00|000000';
       var map = new google.maps.Map(document.getElementById('map'), {
         center: {lat: 55.53, lng: 9.4},
         zoom: 2
       });
       var geocoder = new google.maps.Geocoder;

       var service = new google.maps.DistanceMatrixService;
       service.getDistanceMatrix({
         origins: [origin1],
         destinations: [destinationA],
         travelMode: 'DRIVING',
         unitSystem: google.maps.UnitSystem.METRIC,
         avoidHighways: false,
         avoidTolls: false
       }, function(response, status) {
         if (status !== 'OK') {
           alert('Error was: ' + status);
         } else {
           var originList = response.originAddresses;
           var destinationList = response.destinationAddresses;
           var outputDiv = document.getElementById('output');
           var cabecera = document.getElementById('cabecera');
           outputDiv.innerHTML = '';
           deleteMarkers(markersArray);

           var showGeocodedAddressOnMap = function(asDestination) {
             var icon = asDestination ? destinationIcon : originIcon;
             return function(results, status) {
               if (status === 'OK') {
                 map.fitBounds(bounds.extend(results[0].geometry.location));
                 markersArray.push(new google.maps.Marker({
                   map: map,
                   position: results[0].geometry.location,
                   icon: icon
                 }));
               } else {
                 alert('Geocode was not successful due to: ' + status);
               }
             };
           };

           for (var i = 0; i < originList.length; i++) {
             var results = response.rows[i].elements;
             geocoder.geocode({'address': originList[i]},
                 showGeocodedAddressOnMap(false));
             for (var j = 0; j < results.length; j++) {
               geocoder.geocode({'address': destinationList[j]},
                   showGeocodedAddressOnMap(true));
               cabecera.innerHTML += originList[i] + ' to ' + destinationList[j] +
                   ': ' + results[j].distance.text + ' in ' +
                   results[j].duration.text + '<br>';
             }
           }
         }
       });
     }

     function deleteMarkers(markersArray) {
       for (var i = 0; i < markersArray.length; i++) {
         markersArray[i].setMap(null);
       }
       markersArray = [];
     }
   </script>
   <script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlTnqeL2j1cn8edg8TISE4HdIxRAQguHI&callback=initMap">
   </script>
    <?php endif?>
