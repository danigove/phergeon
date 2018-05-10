<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AnimalesSearch represents the model behind the search form of `app\models\Animales`.
 */
class AnimalesSearch extends Animales
{
    public $distancia;

    public function rules()
    {
        return [
            [['id', 'id_usuario', 'tipo_animal', 'raza'], 'integer'],
            [['nombre', 'distancia', 'descripcion', 'edad', 'sexo'], 'safe'],
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

    public function attributes()
    {
        return array_merge(parent::attributes(), ['distancia']);
    }



    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Animales::find()->joinWith('usuario');
        $x = Yii::$app->user->identity->posx;
        $y = Yii::$app->user->identity->posy;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                   'defaultOrder' => [
                       'distancia' => SORT_ASC,
                   ],
               ],
        ]);

        $dataProvider->sort->attributes['distancia'] = [
            'asc' => ["abs(($x-posx) - ($y-posy))" => SORT_ASC],
            'desc' => ["abs(($x-posx) - ($y-posy))" => SORT_DESC],
        ];



        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_usuario' => $this->id_usuario,
            'tipo_animal' => $this->tipo_animal,
            'raza' => $this->raza,
            'distancia' => $this->distancia,
        ]);

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'edad', $this->edad])
            ->andFilterWhere(['ilike', 'sexo', $this->sexo])
            ->andFilterWhere(['=', 'distancia', $this->distancia]);

        return $dataProvider;
    }
}
