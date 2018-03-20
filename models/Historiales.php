<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "historiales".
 *
 * @property int $id
 * @property int $id_animal
 * @property string $descripcion
 *
 * @property Animales $animal
 */
class Historiales extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'historiales';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_animal', 'descripcion'], 'required'],
            [['id_animal'], 'default', 'value' => null],
            [['id_animal'], 'integer'],
            [['descripcion'], 'string', 'max' => 255],
            [['id_animal'], 'exist', 'skipOnError' => true, 'targetClass' => Animales::className(), 'targetAttribute' => ['id_animal' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_animal' => 'Id Animal',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnimal()
    {
        return $this->hasOne(Animales::className(), ['id' => 'id_animal'])->inverseOf('historiales');
    }
}
