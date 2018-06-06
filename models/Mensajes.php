<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "mensajes".
 *
 * @property int $id
 * @property int $id_receptor
 * @property int $id_emisor
 * @property string $asunto
 * @property string $mensaje
 * @property string $created_at
 * @property bool $visto
 *
 * @property Usuarios $receptor
 * @property Usuarios $emisor
 */
class Mensajes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mensajes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_receptor', 'id_emisor'], 'required'],
            [['id_receptor', 'id_emisor'], 'default', 'value' => null],
            [['id_receptor', 'id_emisor'], 'integer'],
            [['created_at'], 'safe'],
            [['visto'], 'boolean'],
            [['asunto'], 'string', 'max' => 100],
            [['mensaje'], 'string', 'max' => 2000],
            [['id_receptor'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['id_receptor' => 'id']],
            [['id_emisor'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['id_emisor' => 'id']],
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


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_receptor' => 'Id Receptor',
            'id_emisor' => 'Id Emisor',
            'asunto' => 'Asunto',
            'mensaje' => 'Mensaje',
            'created_at' => 'Created At',
            'visto' => 'Visto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptor()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'id_receptor'])->inverseOf('mensajes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmisor()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'id_emisor'])->inverseOf('mensajes0');
    }
}
