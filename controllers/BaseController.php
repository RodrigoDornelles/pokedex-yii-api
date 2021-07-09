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
}
