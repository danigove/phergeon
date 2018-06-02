<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fotosanimal".
 *
 * @property int $id
 * @property int $id_animal
 * @property string $link
 *
 * @property Animales $animal
 */
class Fotosanimal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fotosanimal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_animal'], 'required'],
            [['id_animal'], 'default', 'value' => null],
            [['id_animal'], 'integer'],
            [['link'], 'string', 'max' => 255],
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
            'link' => 'Link',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnimal()
    {
        return $this->hasOne(Animales::className(), ['id' => 'id_animal'])->inverseOf('fotosanimals');
    }
}
