<?php

namespace app\controllers;

use Yii;
use app\models\Pokemon;
use app\models\PokemonSearch;

class ListController extends BaseController
{
    /**
     * List all filtered pokémons.
     *
     * @return string
     */
    public function actionIndex()
    {       
        $searchModel = new PokemonSearch();
        $searchModel->group = 'number';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return [
            'data' => $dataProvider->models,
            'count' => $dataProvider->totalCount,
            'total' => Pokemon::total(),
            'pagination' => $this->pagination($dataProvider),
        ];
    }
}