<?php

namespace app\controllers;

use Yii;
use app\models\Pokemon;

class TypesController extends BaseController
{
    /**
     * List all types of pokémons.
     *
     * @return string
     */
    public function actionIndex()
    {
        $types = Pokemon::types();

        return [
            'data' => $types,
            'count' => count($types)
        ];
    }
}