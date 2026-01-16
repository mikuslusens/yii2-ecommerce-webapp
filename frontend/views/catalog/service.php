<?php
    use yii\helpers\Url;
    use yii\helpers\StringHelper;

    $this->title = $model->name;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'catalog'), 'url' => ['catalog/index']];
    $this->params['breadcrumbs'][] = $this->title;
    $addToCartUrl = Url::toRoute('catalog/add-multiple-to-cart');

    $this->registerJs(<<<JS
        Fancybox.bind("[data-fancybox]", {
            closeButton: true,
        });

        $('.addToCartButton').click(function() {
        var data = {};
        var id = $(this).attr("value");
        var quantity = $('#quantity').val();
        data['id'] = id;
        data['quantity'] = quantity;
        
        $.ajax({
            url: '$addToCartUrl',
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
                    
    
                    alertify.set('notifier','position', 'top-center');
                    alertify.success(res.message);
    
                    //$('#myTable').load(location.href + " #myTable");
                    //location.reload();
    
                }else if(res.status == 500) {
                    alertify.set('notifier','position', 'top-center');
                    alertify.error(res.message);
                }
            }
        });

        
    });
    JS
    );

    //$path_bits = explode("\\", $model->path_to_image ?? ''); ?>
    <h1 style="margin-bottom:50px"><?= $this->title ?></h1>
    <div class="container">
    <div class="row">
       
    <?php if ($model->path_to_image !== null && $model->path_to_image !== '') { ?>
        <div class="col-12 col-sm-4">    
            <a data-fancybox="service" data-src="<?= rtrim(\yii\helpers\Url::base(true), '/') . '/' . ltrim($model->path_to_image, '/') ?>" data-caption="Single image"><img src="<?= rtrim(\yii\helpers\Url::base(true), '/') . '/' . ltrim($model->path_to_image, '/') ?>" style="max-height:400px; max-width:100%; margin-bottom:20px;"></a>
            <div class="row">
                <?php 
                if ($model->extra_images) {
                foreach ($model->extra_images as $image) { ?>
                    <div class="col-4">
                    <?php //$path_bits = explode("\\", $image->path ?? ''); ?>
                        <a data-fancybox="service" data-src="<?= rtrim(\yii\helpers\Url::base(true), '/') . '/' . ltrim($image->path, '/') ?>" data-caption="Single image"><img src="<?= rtrim(\yii\helpers\Url::base(true), '/') . '/' . ltrim($image->path, '/') ?>" style="max-height:100px; max-width:100px"></a>
                    </div>
                <?php } } ?>
            </div>
        </div>
    <?php } ?>
    
        
            <div class="col-12 col-sm-8">
                <p><b>Cena:</b> <?= $model->price ?>&nbsp;EUR</p>
                <br>
                <div style="margin-bottom:20px">
                    <p style="display:block"><b>Daudzums: </b><input type="number" class="cn" id="quantity" min=0 step=1 value="1"><p>
                </div>
                <br>
                <a href="#" class="btn btn-primary addToCartButton" value="<?=$model->id?>">Pievienot grozam <i class="fa-solid fa-cart-shopping"></i></i></a>
            </div>
            <div class="row">
            <div class="col-12 ">
            <hr>
            <h4>Apraksts:</h4>
            <p><?= $model->description ?></p>
            </div>
            </div>
    </div>
    </div>
