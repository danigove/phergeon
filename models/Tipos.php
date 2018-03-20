<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipos".
 *
 * @property int $id
 * @property string $denominacion_tipo
 *
 * @property Animales[] $animales
 * @property Razas[] $razas
 */
class Tipos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['denominacion_tipo'], 'required'],
            [['denominacion_tipo'], 'string', 'max' => 255],
            [['denominacion_tipo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'denominacion_tipo' => 'Denominacion Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnimales()
    {
        return $this->hasMany(Animales::className(), ['tipo_animal' => 'id'])->inverseOf('tipoAnimal');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRazas()
    {
        return $this->hasMany(Razas::className(), ['tipo_animal' => 'id'])->inverseOf('tipoAnimal');
    }
}
