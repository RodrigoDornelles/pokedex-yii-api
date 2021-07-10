<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

/**
 * PokemonSearch represents the model behind the search form about `\app\models\Pokemon`.
 */
class PokemonSearch extends Pokemon
{ 
    public $group;

    /**
     * @inheritdoc
     */
    public function attributes() 
    {
        return ArrayHelper::merge(parent::attributes(), [
            'type'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'type_1', 'type_2', 'name', 'number', 'legendary'], 'safe']
        ];
    }

    /**
     * @inheritdoc
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
        $query = Pokemon::find()
            ->alias('pokemon');

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['number' => SORT_ASC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->group) {
            $query->groupBy(["pokemon.id", $this->group])
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'pokemon.id' => $this->id,
            'pokemon.number' => $this->number,
            'pokemon.legendary' => $this->legendary
        ]);

        // grid filtering by fields */
        $query->andFilterWhere(['ilike', 'pokemon.type_1', $this->type_1])
            ->andFilterWhere(['ilike', 'pokemon.type_2', $this->type_2])
            ->andFilterWhere(['ilike', 'pokemon.name', $this->name]);

        // grid filtering by types in any column
        $query->andFilterWhere(['or',
            ['ilike', 'pokemon.type_1', $this->type],
            ['ilike', 'pokemon.type_1', $this->type],
        ]);
        
        return $dataProvider;
    }
}
