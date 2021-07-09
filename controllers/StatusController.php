<?php

namespace app\controllers;

use Yii;

class StatusController extends BaseController
{
    /**
     * Displays working status api..
     *
     * @return string
     */
    public function actionIndex()
    {
        return Yii::t('app', 'gotta catch em all!');
    }
}