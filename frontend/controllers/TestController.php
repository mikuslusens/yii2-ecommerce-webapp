<?php
namespace frontend\controllers;

use yii\web\Controller;
use Yii;

class TestController extends Controller
{
    public function actionDb()
    {
        try {
            $db = Yii::$app->db;
            $db->open();
            return $this->renderContent('<h2 style="color:green">DB Connected Successfully!</h2>');
        } catch (\Exception $e) {
            return $this->renderContent('<pre style="color:red">DB Failed: ' . $e->getMessage() . '</pre>');
        }
    }
}