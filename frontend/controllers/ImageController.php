<?php

namespace frontend\controllers;

use frontend\models\Image;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ImageController extends \yii\web\Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        //'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }
    
    public function actionDelete()
    {
        if (\Yii::$app->request->isPost) {
            $data = \Yii::$app->request->post();
            //error_log(print_r($data, true));
            $id = $data['id'];
        }
        
        $model = $this->findModel($id);

        if ($model->delete() && unlink($model->path)) {
            $res = [
                'status' => 200,
                'message' => 'Image Deleted'
            ];
            \Yii::$app->session->setFlash('success', 'Your chosen image has been removed');
            
            return json_encode($res);
        } else {
            $res = [
                'status' => 500,
                'message' => 'Image Not Deleted'
            ];
            \Yii::$app->session->setFlash('error', 'Failed to remove your chosen serimage, please contact an administrator');
            
            return json_encode($res);
        }
    }

    protected function findModel($id)
    {
        if (($model = Image::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
    

}
