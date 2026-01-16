<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use frontend\models\Category;
use kartik\file\FileInput;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var frontend\models\Service $model */

$this->title = Yii::t('app', 'Update Service: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
$deleteImageUrl = Url::toRoute('image/delete');
$items_array = ArrayHelper::map(Category::find()->asArray()->all(),'id','name');
$paths = [];
$pathsString = "";

if ($model->extra_images != null) {
    foreach ($model->extra_images as $image) {
        //$path_bits = explode("\\", $image->path);
        $path = rtrim(\yii\helpers\Url::base(true), '/') . '/' . ltrim($image->path, '/');
        array_push($paths, $path);
    }
    $pathsString = implode(',',$paths);
}

$this->registerJs(<<<JS
    $('.image-delete-button').click(function() {
        var data = {};
        var id = $(this).attr("value");
        data['id'] = id;
        //$deleteImageUrl = Url::toRoute('image/delete');
        
        $.ajax({
            url: '$deleteImageUrl',
            type: 'POST', 
            data: data,
            dataType: 'JSON',
            success: function (e, response) {
                
                var res = response;
                if(res.status == 200){
    
                    e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
    
                }else if(res.status == 500) {
                    alert(res.message);
                }
            }
        });

        
    });
JS
);
?>
<div class="service-update">

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
            
            <?php
            
            //$path_bits = explode("\\", $model->path_to_image ?? '');
                    ?><span><img class="card-img-top" src="<?= rtrim(\yii\helpers\Url::base(true), '/') . '/' . ltrim($model->path_to_image, '/') ?>" alt="Card image cap" style = "max-width:200px; max-height:200px;">
            <?php
            echo $form->field($model, 'eventImage')->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => [
                    'uploadUrl' => Url::to(['/service/upload']) . "?id=" . $model->id,
                ]
            ]); ?>
            <?php foreach($model->extra_images as $key => $image) {
                if($image->path) {
                    //$path_bits = explode("\\", $image->path);
                    ?><span><img class="card-img-top" src="<?= rtrim(\yii\helpers\Url::base(true), '/') . '/' . ltrim($image->path, '/') ?>" alt="Card image cap" style = "max-width:200px; max-height:200px;">
                    <?php echo Html::a(
                        'Dzēst',
                        '#',
                        ['class' => 'btn btn-primary image-delete-button', 'title' => 'Dzēst', 'data-pjax' => 0, 'value' => $image->id]
                    ); ?>
            <?php } }
            echo $form->field($model, 'extra_images[]')->widget(FileInput::classname(), [
                'name' => 'extra_images[]',
                'options'=>[
                    'multiple'=>true
                ],
                'pluginOptions' => [
                    //'initialPreview'=>[
                    //    isset($paths[0]) ? $model->[0] : "",
                    //    isset($paths[1]) ? $paths[1] : "",
                    //    isset($paths[2]) ? $paths[2] : "",
                    //    isset($paths[3]) ? $paths[3] : "",
                    //],
                    'uploadUrl' => Url::to(['/service/upload-image']) . "?id=" . $model->id,
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
