<?php

namespace frontend\controllers;

use frontend\models\Post;

class BlogController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPost($id)
    {
        $model = Post::findOne(['id' => $id]);
        return $this->render('post', [
            'model' => $model,
        ]);
    }

}
