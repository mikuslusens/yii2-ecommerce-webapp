<?php

namespace frontend\controllers;

use frontend\models\Service;
use frontend\models\ServiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\MultipleUploadForm;
use frontend\models\Image;

/**
 * ServiceController implements the CRUD actions for Service model.
 */
class ServiceController extends Controller
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
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Service models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ServiceSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Service model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Service model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Service();
        

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->eventImage = UploadedFile::getInstance($model, 'eventImage');
            $model->extra_images = UploadedFile::getInstances($model, 'extra_images');
            
            if ($model->save()) {
                if ($model->eventImage) {
                    $this->actionUpload($model->id);
                }
                if (count($model->extra_images) > 0) {
                    $this->actionUploadImage($model->id);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Service model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $rows = Image::find()
            ->where(['entityId' => $id])
            ->all();

        $model->extra_images=$rows;

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->eventImage = UploadedFile::getInstance($model, 'eventImage');
            $model->extra_images = UploadedFile::getInstances($model, 'extra_images');
            
            if ($model->save()) {
                if ($model->eventImage) {
                    $this->actionUpload($model->id);
                }
                if (count($model->extra_images) > 0) {
                    $this->actionUploadImage($model->id);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Service model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionUpload($id)
    {
        $model = $this->findModel($id);
        
        if (\Yii::$app->request->isPost) {
            $model->eventImage = UploadedFile::getInstance($model, 'eventImage');
            if ($model->upload()) {
                return true;
                //return $this->redirect(['view', 'id' => $model->id]);
        
            }
        }
    
     return false;
    
    }

    function actionUploadImage($id) {
        $form = $this->findModel($id);

        if (\Yii::$app->request->isPost) {
            $form->extra_images = UploadedFile::getInstances($form, 'extra_images');

            if ($form->uploadMultiple()) {
                return true;
                //return $this->redirect(['view', 'id' => $form->id]);
        
            }
        }

        return false;
    }

    /**
     * Finds the Service model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Service the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Service::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
