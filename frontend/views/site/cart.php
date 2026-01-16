<?php 

use yii\helpers\Html;
use yii\helpers\Url;

$icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-trash"]);
$url = Url::toRoute('catalog/delete-from-cart');
$cart = \Yii::$app->cart;

$icons = [
    'eye-open' => '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1.125em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M573 241C518 136 411 64 288 64S58 136 3 241a32 32 0 000 30c55 105 162 177 285 177s230-72 285-177a32 32 0 000-30zM288 400a144 144 0 11144-144 144 144 0 01-144 144zm0-240a95 95 0 00-25 4 48 48 0 01-67 67 96 96 0 1092-71z"/></svg>',
    'pencil' => '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M498 142l-46 46c-5 5-13 5-17 0L324 77c-5-5-5-12 0-17l46-46c19-19 49-19 68 0l60 60c19 19 19 49 0 68zm-214-42L22 362 0 484c-3 16 12 30 28 28l122-22 262-262c5-5 5-13 0-17L301 100c-4-5-12-5-17 0zM124 340c-5-6-5-14 0-20l154-154c6-5 14-5 20 0s5 14 0 20L144 340c-6 5-14 5-20 0zm-36 84h48v36l-64 12-32-31 12-65h36v48z"/></svg>',
    'trash' => '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"/></svg>',
];

$this->title = Yii::t('frontend', 'cart2');

$this->registerJs(<<<JS
    $('.remove-from-cart').click(function() {
        var data = {};
        var id = $(this).attr("value");
        data['id'] = id;
        
        $.ajax({
            url: '$url',
            type: 'POST', 
            data: data,
            dataType: 'JSON',
            success: function (response) {
                
                var res = response;
                if(res.status == 422) {
                    $('#errorMessage').removeClass('d-none');
                    $('#errorMessage').text(res.message);
    
                }else if(res.status == 200){
    
                    $('#errorMessage').addClass('d-none');
                    //$('#saveCategory')[0].reset();
                    //$('#categoryAddModal').modal('hide');
                    
    
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(res.message);
    
                    //$('#myTable').load(location.href + " #myTable");
                    location.reload();
    
                }else if(res.status == 500) {
                    alert(res.message);
                }
            }
        });
    });
JS
);

?> <h1><?= Html::encode($this->title) ?></h1>
<br> <?php

echo \yii2mod\cart\widgets\CartGrid::widget([
    // Some widget property maybe need to change. 
    'cartColumns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'price',
        'quantity',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{myButton}',  // the default buttons + your custom button
            'buttons' => [
                'myButton' => function($url, $model, $key) {     // render your custom button
                    return Html::a(
                        '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"/></svg>',
                        '#',
                        ['class' => 'remove-from-cart', 'title' => 'Dzēst', 'data-pjax' => 0, 'value' => $model->getUniqueId()]
                    );
                }
            ]
        ]
    ]
]); ?>
<br>
<a href="<?=Url::toRoute('site/order')?>" class="btn btn-primary <?php if ($cart->getCount()==0) echo "disabled"?>"><?=Yii::t('frontend', 'create_order')?></a>