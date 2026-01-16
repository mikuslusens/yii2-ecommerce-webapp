<?php

use frontend\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var frontend\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('frontend', 'Orders');
$this->params['breadcrumbs'][] = $this->title;

const STATUS_PROCESSED = 'processed';
const STATUS_WAITING = 'waiting';

function getStatusList(){
    return array(
        STATUS_PROCESSED => 'Processed',
        STATUS_WAITING => 'Waiting',
    );
}

function getStatusValue(){
    $list = getStatusList();
    return array_key_exists( $this->status, $list ) ? $list[ $this->status ] : 'Undefined';
}

?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a(Yii::t('frontend', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'surname',
            'email:email',
            [
                'attribute' => 'date',
                'format' => ['datetime', 'php:d.m.Y'],
            ],
            //'phone',
            //'address:ntext',
            //'cartData:ntext',
            [
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'attribute' => 'status',
                'value' => function ($data) {
                        if ($data->status == 0)
                           return Yii::t('frontend', 'received'); // $data['name'] for array data, e.g. using SqlDataProvider.
                        else if ($data->status == 1)
                            return Yii::t('frontend', 'paid'); // $data['name'] for array data, e.g. using SqlDataProvider.
                        else if ($data->status == 2)
                            return Yii::t('frontend', 'delivered'); // $data['name'] for array data, e.g. using SqlDataProvider.
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Order $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{myButton}',  // the default buttons + your custom button
                'buttons' => [
                    'myButton' => function($url, $model, $key) {     // render your custom button
                        return Html::a(
                            '<i class="fa fa-download" aria-hidden="true"></i>',
                            Url::toRoute(['site/download-invoice', 'id' => $model->id]),
                            ['class' => 'download_invoice', 'title' => 'Lejupielādēt rēķinu', 'data-pjax' => 0, 'value' => $model->id]
                        );
                    }
                ]
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
