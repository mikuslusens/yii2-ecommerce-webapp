<?php
       
use yii\helpers\Url;
use frontend\models\Category;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$width = 0;
$order = null;
$request = Yii::$app->request;
$sort = $request->get('sort');
if(SHOW_CATEGORIES) {
    $width = 6;
} else {
    $width = 4;
}
if(isset($sort)) {
    if ($sort == '2') {
        $order = SORT_DESC;
    } else {
        $order = SORT_ASC;
    }
}
if(isset($categoryId)) {
    $rows = (new \yii\db\Query())
    ->select(['id', 'name', 'description', 'is_new', 'is_discount', 'price', 'old_price', 'path_to_image'])
    ->from('service')
    ->where(['category_id' => $categoryId])
    ->orderBy(['price' => $order])
    ->all();
} else {
    $rows = (new \yii\db\Query())
    ->select(['id', 'name', 'description', 'is_new', 'is_discount', 'price', 'old_price', 'path_to_image'])
    ->from('service')
    ->orderBy(['price' => $order])
    //->where('category_id' => $this->categoryId)
    ->all();
}

$addToCartUrl = Url::toRoute('catalog/add-to-cart');
$indexUrl = Url::toRoute('catalog/index');
$this->title = Yii::t('frontend', 'catalog');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(<<<JS
    $('.addToCartButton').click(function() {
        var data = {};
        var id = $(this).attr("value");
        data['id'] = id;
        
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

    $('.sortButton').change(function(e) {
        var data = {};
        var value = $(this).attr("value");
        data['sort'] = value;
        var urlParams = new URLSearchParams(window.location.search);
        var id = urlParams.get('categoryId');
        data['categoryId'] = id;
        var word = null;
        var symbol = null;

        
        $.ajax({
            url: '$indexUrl',
            type: 'POST', 
            data: data,
            dataType: 'JSON',
            success: function (response) {
                
                if (data['categoryId'] == "" || data['categoryId'] == null) {
                    word = "";
                    symbol = "?";
                }
                else
                {
                    word = "?categoryId=" + data['categoryId'];
                    symbol = "&";
                }
                window.location = '$indexUrl' + word + symbol +"sort=" + data['sort'];
            }
        });

        
    });
JS
);

?>

<div class="container">
    <h1><?=$this->title?></h1>
    <?php ?> 
    <span style="float:right; margin-top: -50px">Kārtot pēc:
    <div id="sortButton"><label><input type="radio" class="sortButton" name="sort" value="1" <?php if(isset($sort) && $sort == '1')  {?> checked <?php } ?>> Lētākajiem</label> <label><input type="radio" class="sortButton" name="sort" value="2"<?php if(isset($sort) && $sort == '2')  {?> checked <?php } ?>> Dārgākajiem</label></div>    </span>
    </span>
    <hr>
    <div class="row">
    
    <div class="col col-sm-3">
    <ol class="list-group" style="margin-bottom:20px">
<?php
    if (SHOW_CATEGORIES) {
    foreach(Category::getAll() as $category) {
?>
    
    <a href="<?=Url::to(['catalog/index', 'categoryId' => $category['id']])?>" class="list-group-item list-group-item-action categoryButton <?= isset($categoryId) && $categoryId == $category['id'] ? "active" : "" ?> value="<?=$category['id']?>"><?=$category->name?><span class="badge bg-primary rounded-pill" style="float:right"><?=$category->howManyInCategory()?></span></a>
    

<?php 
    } }
    ?> </ol></div><div class="col col-sm-<?php if(SHOW_CATEGORIES) { echo "9"; } else { echo "12"; } ?>"><div class="row"><?php
if(count($rows) > 0)
{

    

    foreach($rows as $key => $service)
    {
        //$path_bits = explode("\\", $service['path_to_image'] ?? '');
        ?>
            
            <div class="col-sm-<?=$width?> mb-4">
                <div class="card" style="width: 16rem;">
                <?php if($service['path_to_image']) { ?><img class="card-img-top" src="<?= rtrim(\yii\helpers\Url::base(true), '/') . '/' . ltrim($service['path_to_image'], '/') ?>" alt="Card image cap"> <?php } ?>
                
                <div class="card-body">
                    <span class="badge bg-success rounded-pill" style="float:left;"><?=$service['is_new'] ? "Jaunums!" : ""?></span><!--
    --><span class="badge bg-danger rounded-pill" style="float:left;"><?=$service['is_discount'] ? "Atlaide!" : ""?></span>
    <br>
                    <h5 class="card-title"><a href="<?=Url::toRoute('catalog/service') . "?id=" . $service["id"]?>"><?= $service["name"] ?></a></h5>
                    <p class="card-text"><?=$service['description']?></p>
                    <p><b>Cena: <?=$service['is_discount'] ? "<s style='color:red'>" . $service['old_price'] . "</s> " . $service['price'] . " EUR"  : $service['price'] . " EUR" ?></b></p>
                    <a href="#" class="btn btn-primary addToCartButton" value="<?=$service['id']?>">Pieteikties konsultācijai</a>
                </div>
                </div>
            </div>
        <?php
    }
}
?>
    </div>    
    </div>
    </div>
</div>