<?php

namespace app\models;

use yii\base\Model;

class SolicitarAdopcionForm extends Model
{
    /**
     * Número de identificación del usuario que ha subido al animal
     * @var int
     */
    public $id_donante;
    /**
     * Número de identificación del usuario que quiere adoptar al animal
     * @var int
     */
    public $id_adoptante;
    /**
     * Número de identificación del animal que se solicita para adoptar.
     * @var int
     */
    public $id_animal;

    public function formName()
    {
        return '';
    }

    public function attributeLabels()
    {
        return [
            'id_donante' => 'Número del donante',
            'id_adoptante' => 'Número del solicitante',
            'id_animal' => 'Número del animal',
        ];
    }


    public function rules()
    {
        return [
            [['id_donante', 'id_animal'], 'required'],
        ];
    }
}
