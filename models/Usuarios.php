<?php

namespace app\models;

use Yii;
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
 * @property string $sesskey
 * @property string $token_val
 * @property int $rol
 *
 * @property Animales[] $animales
 * @property Roles $rol0
 */
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    const ESCENARIO_CREATE = 'create';
    const ESCENARIO_UPDATE = 'update';
    public $password_repeat;
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
            [['password', 'password_repeat'], 'required', 'on' => self::ESCENARIO_CREATE],
            [['created_at'], 'safe'],
            [
                ['password_repeat'],
                'compare',
                'compareAttribute' => 'password',
                'skipOnEmpty' => false,
                'on' => [self::ESCENARIO_CREATE, self::ESCENARIO_UPDATE],
            ],
            [['rol'], 'default', 'value' => 1],
            [['rol'], 'integer'],
            [['nombre_usuario', 'nombre_real', 'email', 'password', 'sesskey', 'token_val'], 'string', 'max' => 255],
            [['nombre_usuario'], 'unique'],
            [['rol'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::className(), 'targetAttribute' => ['rol' => 'id']],
        ];
    }

    public function attributes()
    {
        return array_merge(
            parent::attributes(),
            [
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
            'password' => 'Password',
            'password_repeat' => 'Repetir contraseña',
            'created_at' => 'Created At',
            'sesskey' => 'Sesskey',
            'token_val' => 'Token Val',
            'rol' => 'Rol',
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
     * @return \yii\db\ActiveQuery
     */
    public function getRol0()
    {
        return $this->hasOne(Roles::className(), ['id' => 'rol'])->inverseOf('usuarios');
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->token_val = Yii::$app->security->generateRandomString();
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
