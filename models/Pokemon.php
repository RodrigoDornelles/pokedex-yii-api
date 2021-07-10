<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "pokemon".
 *
 * @property int $id
 * @property int $number
 * @property string $name
 * @property string $type_1
 * @property string|null $type_2
 * @property int $total
 * @property int $hp
 * @property int $attack
 * @property int $defense
 * @property int $special_attack
 * @property int $special_defence
 * @property int $speed
 * @property int $generation
 * @property bool $legendary
 */
class Pokemon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pokemon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number', 'name', 'type_1', 'total', 'hp', 'attack', 'defense', 'special_attack', 'special_defence', 'speed', 'generation'], 'required'],
            [['number', 'total', 'hp', 'attack', 'defense', 'special_attack', 'special_defence', 'speed', 'generation'], 'integer'],
            [['legendary'], 'boolean'],
            [['name'], 'string', 'max' => 128],
            [['type_1', 'type_2'], 'string', 'max' => 32],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

    /**
     * @return integer
     */
    public static function total()
    {
        return Pokemon::find()
            ->select('number')
            ->distinct()
            ->count();
    }

    /**
     * @return array
     */
    public static function types()
    {
        return array_unique(array_merge(
            Pokemon::find()
                ->where('type_2 IS NOT NULL')
                ->select('type_2')
                ->distinct()
                ->asArray()
                ->column(),
            Pokemon::find()
                ->select('type_1')
                ->distinct()
                ->asArray()
                ->column()
        ));
    }
}
