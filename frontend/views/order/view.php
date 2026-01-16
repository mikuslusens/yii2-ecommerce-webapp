<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var frontend\models\Order $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('frontend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('frontend', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('frontend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'surname',
            'email:email',
            'phone',
            'address:ntext',
            'cartData:ntext',
            [
                //'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'attribute' => 'status',
                'value' => function ($data) {
                        if ($data->status == 0)
                           return Yii::t('frontend', 'received'); // $data['name'] for array data, e.g. using SqlDataProvider.
                        else if ($data->status == 1)
                            return Yii::t('frontend', 'paid'); // $data['name'] for array data, e.g. using SqlDataProvider.
                        else if ($data->status == 1)
                            return Yii::t('frontend', 'delivered'); // $data['name'] for array data, e.g. using SqlDataProvider.
                },
            ],
        ],
    ]) ?>

</div>
