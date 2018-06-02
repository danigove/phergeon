<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\imagine\Image;

/**
 * This is the model class for table "animales".
 *
 * @property int $id
 * @property int $id_usuario
 * @property string $nombre
 * @property int $tipo_animal
 * @property int $raza
 * @property string $descripcion
 * @property string $edad
 * @property string $sexo
 * @property float $distancia
 *
 * @property Razas $raza0
 * @property Tipos $tipoAnimal
 * @property Usuarios $usuario
 * @property Facturas[] $facturas
 * @property HistorialMedico[] $historialMedicos
 */
class Animales extends \yii\db\ActiveRecord
{
    /**
     * Foto del animal.
     * @var [type]
     */
    public $foto;
    /**
     * {@inheritdoc}
     */
    /**
     * Calculo de la distancia en la que se encuentra el animal.
     * @var [type]
     */
    public $distancia;

    public static function tableName()
    {
        return 'animales';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'distancia'], 'safe'],
            [['nombre', 'tipo_animal', 'raza', 'descripcion', 'edad', 'sexo'], 'required'],
            [['id_usuario', 'tipo_animal', 'raza'], 'default', 'value' => null],
            [['id_usuario', 'tipo_animal', 'raza'], 'integer'],
            [['foto'], 'file', 'extensions' => 'jpg'],
            [['nombre', 'descripcion', 'edad', 'sexo'], 'string', 'max' => 255],
            [['raza'], 'exist', 'skipOnError' => true, 'targetClass' => Razas::className(), 'targetAttribute' => ['raza' => 'id']],
            [['tipo_animal'], 'exist', 'skipOnError' => true, 'targetClass' => Tipos::className(), 'targetAttribute' => ['tipo_animal' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_usuario' => 'Id Usuario',
            'nombre' => 'Nombre',
            'tipo_animal' => 'Tipo Animal',
            'raza' => 'Raza',
            'descripcion' => 'Descripcion',
            'edad' => 'Edad',
            'sexo' => 'Sexo',
            'foto' => 'Foto del animal',
            'distancia' => 'Distancia del usuario',
        ];
    }

    public function attributes()
    {
        return array_merge(
            parent::attributes(),
            [
                'foto',
                'distancia',
            ]
        );
    }

    /**
     * Funcion para subir fotos de animales.
     * @return [type] [description]
     */
    public function upload()
    {
        if ($this->foto === null) {
            return true;
        }
        $nombre = Yii::getAlias('@uploads/') . 'animales-' . Yii::$app->security->generateRandomString() . '.jpg';
        // $nombre = './uploads/' . $this->id . '.jpg';
        $res = $this->foto->saveAs($nombre);
        if ($res) {
            Image::thumbnail($nombre, 80, null)->save($nombre);
        }

        $client = new \Spatie\Dropbox\Client(getenv('DROPBOX_TOKEN'));

        $client->upload($nombre, file_get_contents($nombre), 'overwrite');

        $res = $client->createSharedLinkWithSettings($nombre, ['requested_visibility' => 'public']);

        $url = $res['url'][mb_strlen($res['url']) - 1] = 1;
        $this->foto = $res['url'];
        $this->save();
        return $res;
    }

    /**
     * Método con el que accedemos a la ruta de la imagen de la fotografia del animal.
     * @return [type] [description]
     */
    public function getRutaImagen()
    {
        $nombre = Yii::getAlias('@uploads/') . 'animales-' . $this->id . '.jpg';
        // $nombre = Yii::getAlias();
        if (file_exists($nombre)) {
            // return Url::to('/uploads/') . $this->id . '.jpg';
            return 'https://www.dropbox.com/s/p2wk6t5r6vphtgd/' . 'animales-' . $this->id . '.jpg?dl=1';
        }
        return 'https://www.dropbox.com/s/aek3h7057e88v2d/animal-default.jpg?dl=1';
        // https://www.dropbox.com/s/qq1kje0eet6gwrg/animal-default.jpg?dl=1';
        // return Url::to('/uploads/') . 'default.jpg';
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRaza0()
    {
        return $this->hasOne(Razas::className(), ['id' => 'raza'])->inverseOf('animales');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoAnimal()
    {
        return $this->hasOne(Tipos::className(), ['id' => 'tipo_animal'])->inverseOf('animales');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'id_usuario'])->inverseOf('animales');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturas()
    {
        return $this->hasMany(Facturas::className(), ['id_animal' => 'id'])->inverseOf('animal');
    }
    /**
     * [getAdopciones description].
     * @return [type] [description]
     */
    public function getAdopciones()
    {
        return $this->hasMany(Adopciones::className(), ['id_animal' => 'id'])->inverseOf('animal');
    }

    /**
     * Método que devuelve todos los tipos de animales posibles.
     * @return [type] [description]
     */
    public function getTipos()
    {
        $tipos = Tipos::find()->all();

        $aux;
        for ($i = 0; $i < count($tipos); $i++) {
            $aux[$tipos[$i]['id']] = $tipos[$i]['denominacion_tipo'];
        }

        return $aux;
    }

    /**
     * Método que nos devuelve los tipos de género que puede tener el animal.
     * @return array Array con todos los sexos posibles del animal.
     */
    public function getSexosPosibles()
    {
        $sexos = [
            '0' => 'Macho',
            '1' => 'Hembra',
        ];
        return $sexos;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistorialMedicos()
    {
        return $this->hasMany(Historiales::className(), ['id_animal' => 'id'])->inverseOf('animal');
    }

    /**
     * Devuelve la ruta del animal.
     * @param  int      $id id del animal que queremos saber la ruta.
     * @return string   Ruta en la que se encuentra el perfil del usuario.
     */
    public function rutaAnimal($id)
    {
        $ruta = Url::toRoute(['animales/view', 'id' => $id], true);
        return  $ruta;
    }

    /**
     * Metódo que da como resultado una cadena con las categorías del animal para mandarlas correctamente via Twitter
     * TODO Que pase las etiquetas de verdad, de momento es una prueba.
     * @return string String con todas las categorías separadas por comas.
     */
    public function etiquetasAnimal()
    {
        $string = 'perro,gato,meme';
        return $string;
    }

    /**
     * Comprueba si un animal ya está solicitado por el usuario o no.
     * @param  int $id numero del animal
     * @return bool si esta o no solicitado ya por el usuario
     */
    public function estaSolicitado($id)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        return Adopciones::findOne(['id_usuario_adoptante' => Yii::$app->user->identity->id, 'id_animal' => $id]);
    }

    /**
     * Método que sin la ayuda de las peticiones de calculos de distancias a la API de Google Maps nos permitirá saber
     * dónde está el animal mediante la diferencia de los puntos cardinales en el que se encuentra tanto el usuario como el
     * solicitante de la adopción.
     * @return [type] [description]
     */
    public function distancia()
    {
        if (Yii::$app->user->isGuest) {
            return 0;
        }
        $restalong = Yii::$app->user->identity->posx - $this->usuario->posx;
        $restalat = Yii::$app->user->identity->posy - $this->usuario->posy;
        //TODO Que la vista haga la peticion con las dos distancias.
        return abs($restalong - $restalat);
    }

    // public function getDistancia()
    // {
    //     return 150;
    // }

    // public function afterFind()
    // {
    //     $this->distancia = $this->distancia();
    // }
}
