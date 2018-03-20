<?php

namespace app\models;

use Yii;

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
     * {@inheritdoc}
     */
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
            [['id_usuario', 'nombre', 'tipo_animal', 'raza', 'descripcion', 'edad', 'sexo'], 'required'],
            [['id_usuario', 'tipo_animal', 'raza'], 'default', 'value' => null],
            [['id_usuario', 'tipo_animal', 'raza'], 'integer'],
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
        ];
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
     * @return \yii\db\ActiveQuery
     */
    public function getHistorialMedicos()
    {
        return $this->hasMany(HistorialMedico::className(), ['id_animal' => 'id'])->inverseOf('animal');
    }
}
