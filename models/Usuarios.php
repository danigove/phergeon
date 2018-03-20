<?php

namespace app\models;

use Yii;

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
class Usuarios extends \yii\db\ActiveRecord
{
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
            [['nombre_usuario', 'nombre_real', 'email', 'password'], 'required'],
            [['created_at'], 'safe'],
            [['rol'], 'default', 'value' => null],
            [['rol'], 'integer'],
            [['nombre_usuario', 'nombre_real', 'email', 'password', 'sesskey', 'token_val'], 'string', 'max' => 255],
            [['nombre_usuario'], 'unique'],
            [['rol'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::className(), 'targetAttribute' => ['rol' => 'id']],
        ];
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
            'created_at' => 'Created At',
            'sesskey' => 'Sesskey',
            'token_val' => 'Token Val',
            'rol' => 'Rol',
        ];
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
}
