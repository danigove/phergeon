<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "facturas".
 *
 * @property int $id
 * @property int $id_animal
 * @property string $fecha_emision
 * @property string $centro_veterinario
 * @property string $descripcion
 * @property string $importe
 *
 * @property Animales $animal
 */
class Facturas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'facturas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_animal', 'centro_veterinario', 'descripcion', 'importe'], 'required'],
            [['id_animal'], 'default', 'value' => null],
            [['id_animal'], 'integer'],
            [['fecha_emision'], 'safe'],
            [['importe'], 'number'],
            [['importe'], 'match', 'pattern' => '/[0-9]{3}\.[0-9]{1,2}/', 'message' => 'Necesitas marcar los decimales'],
            [['centro_veterinario', 'descripcion'], 'string', 'max' => 255],
            [['id_animal'], 'exist', 'skipOnError' => true, 'targetClass' => Animales::className(), 'targetAttribute' => ['id_animal' => 'id']],
        ];
    }
    public function behaviors()
    {
        return [
                [
                    'class' => TimestampBehavior::className(),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['fecha_emision'],
                    ],
                    // if you're using datetime instead of UNIX timestamp:
                    'value' => new Expression('NOW()'),
                ],
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
            'fecha_emision' => 'Fecha Emision',
            'centro_veterinario' => 'Centro Veterinario',
            'descripcion' => 'Descripcion',
            'importe' => 'Importe',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnimal()
    {
        return $this->hasOne(Animales::className(), ['id' => 'id_animal'])->inverseOf('facturas');
    }
}
