<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\imagine\Image;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nombre_usuario
 * @property string $nombre_real
 * @property string $email
 * @property string $password
 * @property string $created_at
 * @property float $posx
 * @property float $posy

 * @property string $token_val
 * @property int $rol
 *
 * @property Animales[] $animales
 * @property Roles $rol0
 */
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * Escenario en el que declaramos que el usuario se está CREANDO.
     * @var string
     */
    const ESCENARIO_CREATE = 'create';
    /**
     * Escenario en el que declaramos que el usuario se esta MODIFICANDO.
     * @var string
     */
    const ESCENARIO_UPDATE = 'update';
    /**
     * Variable en la que el usuario tendrá que repetir la contraseña para que
     * no haya equivocaciones.
     * @var string
     */
    public $password_repeat;

    /**
     * Variable en la que el usuario tendrá guardada la foto de perfil.
     * @var [type]
     */
    // public $foto;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_usuario', 'nombre_real', 'email'], 'required'],
            ['email', 'email'],
            [['password', 'password_repeat'], 'required', 'on' => self::ESCENARIO_CREATE],
            [['created_at', 'posx', 'posy'], 'safe'],
            [
                ['password_repeat'],
                'compare',
                'compareAttribute' => 'password',
                'skipOnEmpty' => false,
                'on' => [self::ESCENARIO_CREATE, self::ESCENARIO_UPDATE],
            ],
            [['foto'], 'file', 'extensions' => 'jpg'],
            [['rol'], 'default', 'value' => 1],
            [['rol'], 'integer'],
            [['nombre_usuario', 'nombre_real', 'email', 'password',  'token_val'], 'string', 'max' => 255],
            [['nombre_usuario'], 'unique'],
            [['rol'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::className(), 'targetAttribute' => ['rol' => 'id']],
        ];
    }

    public function attributes()
    {
        return array_merge(
            parent::attributes(),
            [
                'posx',
                'posy',
                // 'foto',
                'password_repeat',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_usuario' => 'Nombre Usuario',
            'nombre_real' => 'Nombre Real',
            'email' => 'Email',
            'password' => 'Contraseña',
            'password_repeat' => 'Repetir contraseña',
            'created_at' => 'Created At',
            'posx' => 'Coordenada X',
            'posy' => 'Coordenada Y',
            // 'sesskey' => 'Sesskey',
            'token_val' => 'Token Val',
            'rol' => 'Rol',
            'foto' => 'Foto de perfil',
        ];
    }

    public function behaviors()
    {
        return [
                [
                    'class' => TimestampBehavior::className(),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ],
                    // if you're using datetime instead of UNIX timestamp:
                    'value' => new Expression('NOW()'),
                ],
            ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        // return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        // return $this->authKey === $authKey;
    }

    /**
     * Función en la que subimos nuestra foto a la carpeta de Dropbox de la aplicación.
     * @return [type] [description]
     */
    public function upload()
    {
        if ($this->foto === null) {
            return true;
        }
        $nombre = Yii::getAlias('@uploads/') . Yii::$app->security->generateRandomString() . '-usuario.jpg';
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
        // $this->save();
        return $res;
    }

    /**
     * Método con el que accedemos a la ruta de la imagen de la fotografia.
     * @return string ruta del enlace.
     */
    public function getRutaImagen()
    {
        if ($this->foto != null) {
            return $this->foto;
        }
        return 'https://www.dropbox.com/s/qq1kje0eet6gwrg/default.jpg?dl=1';
    }


    /**
     * Función que autentica la contraseña del usuario.
     * @param  string $password Contraseña que introduce el usuario.
     * @return bool             Devuelve si la contraseña es o no correcta.
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword(
            $password,
            $this->password
        );
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnimales()
    {
        return $this->hasMany(Animales::className(), ['id_usuario' => 'id'])->inverseOf('usuario');
    }

    /**
     * Obtiene el numero de adopciones que tiene el usuario.
     * @return [type] [description]
     */
    public function getAdopciones0()
    {
        return $this->hasMany(Adopciones::className(), ['id_usuario_adoptante' => 'id'])->inverseOf('usuario');
    }
    /**
     * Obtiene el numero de adopciones que tiene el usuario.
     * @return [type] [description]
     */
    public function getAdopciones()
    {
        return $this->hasMany(Adopciones::className(), ['id_usuario_donante' => 'id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRol0()
    {
        return $this->hasOne(Roles::className(), ['id' => 'rol'])->inverseOf('usuarios');
    }

    public function getMensajes0()
    {
        return $this->hasOne(Mensajes::className(), ['id_emisor' => 'id'])->inverseOf('usuarios');
    }
    /**
     * Obtiene el numero de solicitudes que tiene el usuario.
     * @param  int $id  El id del usuario
     * @return int El numero de solicitudes que tiene.
     */
    public function getNumSolicitudes($id)
    {
        // $solicitudes = Adopciones::find(['id_usuario_donante' => 'id', 'aprobado' => false]);
        $solicitudes = Adopciones::findAll(['id_usuario_donante' => $id, 'aprobado' => false]);
        return count($solicitudes);
    }

    /**
     * Metodo que nos devuelve el numero de mensajes sin ver del usuario.
     * @return int Numero de mensajes sin leer.
     */
    public function getNumMensajesNuevos()
    {
        $mensajesSin = Mensajes::findAll(['id_receptor' => $this->id, 'visto' => false]);
        return count($mensajesSin);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                // $this->token_val = Yii::$app->security->generateRandomString();
                if ($this->scenario === self::ESCENARIO_CREATE) {
                    $this->password = Yii::$app->security->generatePasswordHash($this->password);
                }
            } else {
                if ($this->scenario === self::ESCENARIO_UPDATE) {
                    if ($this->password === '') {
                        $this->password = $this->getOldAttribute('password');
                    } else {
                        $this->password = Yii::$app->security->generatePasswordHash($this->password);
                    }
                }
            }
            return true;
        }
        return false;
    }
}
