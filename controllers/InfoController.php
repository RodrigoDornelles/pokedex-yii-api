<?php

namespace app\controllers;

use Yii;
use app\models\Pokemon;
use yii\web\NotFoundHttpException;

class InfoController extends BaseController
{
    /**
     * View single pokémon info.
     *
     * @return string
     */
    public function actionId($id)
    {       
        return $this->findModel(['id' => $id]);
    }

    /**
     * View single pokémon info.
     *
     * @return string
     */
    public function actionNumber($id)
    {       
        return $this->findModel(['number' => $id]);
    }

    /**
     * @throws NotFoundHttpException
     * @return object
     */
    protected function findModel($where)
    {
        if (($model = Pokemon::findOne($where)) === null){
            throw new NotFoundHttpException('pokemon number not found.');
        }

        return $model;
    }
}