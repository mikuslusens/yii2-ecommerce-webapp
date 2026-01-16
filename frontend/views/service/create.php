<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use frontend\models\Category;
use kartik\file\FileInput;

/** @var yii\web\View $this */
/** @var frontend\models\Service $model */

$this->title = Yii::t('app', 'Create Service');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$paths = null;
if ($model->extra_images != null) {
    foreach ($model->extra_images as $image) {
        $paths .= $image->path . ",";
    }
}

$items_array = ArrayHelper::map(Category::find()->asArray()->all(),'id','name')
?>
<div class="service-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        use yii\widgets\ActiveForm;

        $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
        ]) ?>
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'description') ?>
            <?= $form->field($model, 'price') ?>
            <?= $form->field($model, 'is_new') ?>
            <?= $form->field($model, 'is_discount') ?>
            <?= $form->field($model, 'category_id')->dropdownList([
                    $items_array,
                ],  
                ['prompt'=> Yii::t('frontend', 'choose_category')]
            )?>
            <?= $form->field($model, 'eventImage')->fileInput() ?>
            
            <?= $form->field($model, 'extra_images[]')->fileInput(['multiple' => true]) ?>
            <?php echo FileInput::widget([
                'name' => 'extra_images[]',
                'options'=>[
                    'multiple'=>true
                ],
                'pluginOptions' => [
                    'initialPreview'=>[
                        $paths
                    ],
                    'initialPreviewAsData'=>true,
                    'deleteUrl' => "/site/file-delete",
                    //'initialCaption'=>"The Moon and the Earth",
                    //'initialPreviewConfig' => [
                    //    ['caption' => 'Moon.jpg', 'size' => '873727'],
                    //    ['caption' => 'Earth.jpg', 'size' => '1287883'],
                    //],
                    'overwriteInitial'=>false,
                    'maxFileSize'=>2800
                ]
            ]); ?>
            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::submitButton(Yii::t('frontend', 'add_service'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
    <?php ActiveForm::end() ?>

</div>