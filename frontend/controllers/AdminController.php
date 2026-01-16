<?php

namespace frontend\controllers;

use Yii;
use common\models\User;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if (!isset(Yii::$app->user->identity->username)) {
            return $this->goHome();
        }

        if (!User::isUserAdmin(Yii::$app->user->identity->username)) {
            return $this->goHome();
        }
        
        return $this->render('index');
    }

}

