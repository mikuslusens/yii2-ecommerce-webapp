<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\Order $model */
/** @var yii\widgets\ActiveForm $form */

$items_array = array(Yii::t('frontend', 'received'), Yii::t('frontend', 'paid'), Yii::t('frontend', 'delivered'));
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'cartData')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropdownList([
                    $items_array,
                ],  
                ['prompt'=> Yii::t('frontend', 'choose_status')],
            ) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('frontend', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
