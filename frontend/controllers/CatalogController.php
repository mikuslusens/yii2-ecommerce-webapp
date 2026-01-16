<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use frontend\models\Service;
use frontend\models\Image;

class CatalogController extends \yii\web\Controller
{
    public function actionIndex($categoryId = null, $sort = null)
    {   
        if (\Yii::$app->request->isPost) {
            $data = \Yii::$app->request->post();
            return $data['sort'];
            return $this->render('index', [
                'sort' => $data['sort'],
            ]);
        
        }
        if ($categoryId) {
            return $this->render('index', [
                'categoryId' => $categoryId,
            ]);
        
        } else {
            return $this->render('index');
        }
    }

    public function actionAddToCart()
    {
        $cart = \Yii::$app->cart;
        
        if (\Yii::$app->request->isPost) {
            $data = \Yii::$app->request->post();
            //error_log(print_r($data, true));
            $id = $data['id'];
        }
        $product = Service::findOne(['id' => $id]);
        
        if ($cart->add($product)) {

            $res = [
                'status' => 200,
                'message' => 'Category Updated Successfully'
            ];
            Yii::$app->session->setFlash('success', 'Your chosen service has been added to the cart');
            
            return json_encode($res);
        }
        else
        {
            $res = [
                'status' => 500,
                'message' => 'Category Not Updated'
            ];
            Yii::$app->session->setFlash('error', 'Failed to add your chosen service to the cart, please contact an administrator');
            
            return json_encode($res);
        }
    }

    public function actionAddMultipleToCart()
    {
        $cart = \Yii::$app->cart;
        $data = null;

        if (\Yii::$app->request->isPost) {
            $data = \Yii::$app->request->post();
            //error_log(print_r($data, true));
            $id = $data['id'];
            $quatity = $data['quantity'];
        } else {
            return;
        }

        if ($quatity < 1) {
            $res = [
                'status' => 500,
                'message' => 'Please specify a quantity larger than 0'
            ];
                
            return json_encode($res);
        }

        $product = Service::findOne(['id' => $id]);
        
        for ($x = 1; $x <= $quatity; $x++) {
            if ($cart->add($product)) {

                $res = [
                    'status' => 200,
                    'message' => 'Your chosen service has been added to the cart'
                ];
                
                return json_encode($res);
            }
            else
            {
                $res = [
                    'status' => 500,
                    'message' => 'Failed to add your chosen service to the cart, please contact an administrator'
                ];
                //Yii::$app->session->setFlash('error', 'Failed to add your chosen service to the cart, please contact an administrator');
                
                return json_encode($res);
            }
        }
        //Yii::$app->session->setFlash('success', 'Your chosen service has been added to the cart');
        return json_encode($res);
    }

    public function actionDeleteFromCart()
    {
        $cart = \Yii::$app->cart;
        $cart->init();
        
        if (\Yii::$app->request->isPost) {
            $data = \Yii::$app->request->post();
            //error_log(print_r($data, true));
            $id = $data['id'];
        }
        //$product = Service::findOne(['id' => $id]);
        
        if ($cart->remove($id)) {

            $res = [
                'status' => 200,
                'message' => 'Category Updated Successfully'
            ];
            Yii::$app->session->setFlash('success', 'Your chosen service has been removed from the cart');
            
            return json_encode($res);
        }
        else
        {
            $res = [
                'status' => 500,
                'message' => 'Category Not Updated'
            ];
            Yii::$app->session->setFlash('error', 'Failed to remove your chosen service from the cart, please contact an administrator');
            
            return json_encode($res);
        }
    }

    public function actionService($id) 
    {
        $model = Service::findOne(['id' => $id]);

        $rows = Image::find()
            ->where(['entityId' => $id])
            ->all();

        $model->extra_images=$rows;
        
        return $this->render('service', [
            'model' => $model,
        ]);
    }

}