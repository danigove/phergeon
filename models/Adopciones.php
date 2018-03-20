<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "adopciones".
 *
 * @property int $id
 * @property int $id_usuario_donante
 * @property int $id_usuario_adoptante
 * @property int $id_animal
 * @property string $fecha_adopcion
 *
 * @property Animales $animal
 * @property Usuarios $usuarioDonante
 * @property Usuarios $usuarioAdoptante
 */
class Adopciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adopciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario_donante', 'id_usuario_adoptante', 'id_animal'], 'required'],
            [['id_usuario_donante', 'id_usuario_adoptante', 'id_animal'], 'default', 'value' => null],
            [['id_usuario_donante', 'id_usuario_adoptante', 'id_animal'], 'integer'],
            [['fecha_adopcion'], 'safe'],
            [['id_animal'], 'exist', 'skipOnError' => true, 'targetClass' => Animales::className(), 'targetAttribute' => ['id_animal' => 'id']],
            [['id_usuario_donante'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['id_usuario_donante' => 'id']],
            [['id_usuario_adoptante'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['id_usuario_adoptante' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_usuario_donante' => 'Id Usuario Donante',
            'id_usuario_adoptante' => 'Id Usuario Adoptante',
            'id_animal' => 'Id Animal',
            'fecha_adopcion' => 'Fecha Adopcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnimal()
    {
        return $this->hasOne(Animales::className(), ['id' => 'id_animal'])->inverseOf('adopciones');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioDonante()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'id_usuario_donante'])->inverseOf('adopciones');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioAdoptante()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'id_usuario_adoptante'])->inverseOf('adopciones0');
    }
}
