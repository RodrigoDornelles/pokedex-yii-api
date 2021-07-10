<?php

namespace app\controllers;

use Yii;
use yii\filters\Cors;
use yii\web\Controller;

class BaseController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' =>  Cors::classname(),
                'cors' => ['Origin' => ['*']]
            ]
        ];
    }

    /**
     * @return array|false
     */
    public function pagination($dataProvider)
    {
        if (!$dataProvider || !$dataProvider->pagination) {
            return false;
        }

        return [
            'page' => $dataProvider->pagination->page,
            'pageCount'  => $dataProvider->pagination->pageCount,
            'pageSize' => $dataProvider->pagination->pageSize
        ];
    }
}
