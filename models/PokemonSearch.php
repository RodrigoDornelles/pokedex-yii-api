<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\db\Expression;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

/**
 * PokemonSearch represents the model behind the search form about `\app\models\Pokemon`.
 */
class PokemonSearch extends Pokemon
{ 
    public $distinct;

    /**
     * @inheritdoc
     */
    public function attributes() 
    {
        return ArrayHelper::merge(parent::attributes(), [
            'mega'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_1', 'type_2', 'name', 'mega', 'number', 'legendary'], 'safe']
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
                'defaultOrder' => [
                    'number' => SORT_ASC,
                    'id' => SORT_ASC
                ],
            ],
        ]);

        // ordering by types
        $dataProvider->sort->attributes['type'] = [
            'asc' => [
                '(type_2 IS NULL)' => SORT_ASC,
                'type_1' => SORT_ASC,
                'type_2' => SORT_DESC
            ],
            'desc' => [
                '(type_2 IS NULL)' => SORT_ASC,
                'type_1' => SORT_DESC,
                'type_2' => SORT_ASC
            ],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'pokemon.id' => $this->id,
            'pokemon.number' => $this->number,
            'pokemon.legendary' => $this->legendary
        ]);

        // grid filtering by name */
        $query->andFilterWhere(['like', 'pokemon.name', $this->name]);

        // grid filtering by types
        if ($this->type_1 && $this->type_2) {
            $query->andFilterWhere(['or',
                ['and',
                    ['like', 'pokemon.type_1', $this->type_1],
                    ['like', 'pokemon.type_2', $this->type_2],
                ],
                ['and',
                    ['like', 'pokemon.type_1', $this->type_2],
                    ['like', 'pokemon.type_2', $this->type_1],
                ],
            ]);
        }
        else if ($this->type_1) {
            $query->andFilterWhere(['or',
                ['like', 'pokemon.type_1', $this->type_1],
                ['like', 'pokemon.type_2', $this->type_1],
            ]);
        }
        else if ($this->type_2) {
            $query->andFilterWhere(['or',
                ['like', 'pokemon.type_1', $this->type_2],
                ['like', 'pokemon.type_2', $this->type_2],
            ]);
        }

        // grid filtering by mega evolution
        if ($this->mega) {
            $query->andFilterWhere(['or',
                ['like', 'pokemon.name', 'mega'],
                ['like', 'pokemon.name', 'primal'],
            ]);
        }

        // postgres distinct
        if ($this->distinct && strpos(Yii::$app->db->dsn, 'pgsql') !== false) {
            $query->select(new Expression("*, ROW_NUMBER() OVER (PARTITION BY {$this->distinct} ORDER BY id) as r"));
            $query = strtr($query->createCommand()->getRawSql(), ['LIKE' => 'ILIKE']);
            $dataProvider->query = (new Query())->from(new Expression("({$query}) as p"));
            $dataProvider->query->andWhere(["r" => 1]);
        }
        // sqlite distinct
        else if ($this->distinct && strpos(Yii::$app->db->dsn, 'sqlite') !== false) {
            $query->groupBy($this->distinct);
        }
        
        return $dataProvider;
    }
}
