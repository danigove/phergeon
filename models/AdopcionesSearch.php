<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Adopciones;

/**
 * AdopcionesSearch represents the model behind the search form of `app\models\Adopciones`.
 */
class AdopcionesSearch extends Adopciones
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_usuario_donante', 'id_usuario_adoptante', 'id_animal'], 'integer'],
            [['aprobado'], 'boolean'],
            [['fecha_adopcion'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Adopciones::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_usuario_donante' => $this->id_usuario_donante,
            'id_usuario_adoptante' => $this->id_usuario_adoptante,
            'id_animal' => $this->id_animal,
            'aprobado' => $this->aprobado,
            'fecha_adopcion' => $this->fecha_adopcion,
        ]);

        return $dataProvider;
    }
}
