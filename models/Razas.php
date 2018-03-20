<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "razas".
 *
 * @property int $id
 * @property int $tipo_animal
 * @property string $denominacion_raza
 *
 * @property Animales[] $animales
 * @property Tipos $tipoAnimal
 */
class Razas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'razas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_animal', 'denominacion_raza'], 'required'],
            [['tipo_animal'], 'default', 'value' => null],
            [['tipo_animal'], 'integer'],
            [['denominacion_raza'], 'string', 'max' => 255],
            [['denominacion_raza'], 'unique'],
            [['tipo_animal'], 'exist', 'skipOnError' => true, 'targetClass' => Tipos::className(), 'targetAttribute' => ['tipo_animal' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo_animal' => 'Tipo Animal',
            'denominacion_raza' => 'Denominacion Raza',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnimales()
    {
        return $this->hasMany(Animales::className(), ['raza' => 'id'])->inverseOf('raza0');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoAnimal()
    {
        return $this->hasOne(Tipos::className(), ['id' => 'tipo_animal'])->inverseOf('razas');
    }
}
