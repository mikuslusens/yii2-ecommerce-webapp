<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\Order $model */
/** @var ActiveForm $form */

$cart = \Yii::$app->cart;

$json = [];
foreach ($cart->getItems(true, null) as $item) {
    $serializeditem = json_encode($item);
    array_push($json, $serializeditem);

}

$this->title = Yii::t('frontend', 'create_order');
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="order">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'surname') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'address') ?>
        <?= $form->field($model, 'cartData')->hiddenInput([ 'value' => json_encode($json, JSON_PRETTY_PRINT)])->label(false) ?>
        <?= $form->field($model, 'date')->hiddenInput([ 'value' => date("Y-m-d H:i:s")])->label(false) ?>
        <?= $form->field($model, 'status')->hiddenInput([ 'value' => 0])->label(false) ?>

    
        <div class="form-group">
            <?= Html::submitButton(Yii::t('frontend', 'order'), ['class' => 'btn btn-primary', 'id' => 'submitOrder']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- order -->
