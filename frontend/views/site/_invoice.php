<?php
use yii\helpers\Html;
use frontend\models\Service;

header('Content-Type: text/html; charset=utf-8');

$fmt = datefmt_create(
    'lv_LV',
    IntlDateFormatter::LONG,
    IntlDateFormatter::NONE,
);

$cart = \Yii::$app->cart;
$query = frontend\models\Order::find();
$cartDataProvider = new \yii\data\ActiveDataProvider( [ 'query' => $query]);

$fixed_data = preg_replace_callback ( '!s:(\d+):"(.*?)";!', function($match) {      
    return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
},$model->cartData );

$models = [];
foreach (json_decode($model->cartData) as $item) {
    $newitem = json_decode($item);
    //array_push($models, $newitem);
    $service = new Service();
    $service->id = $newitem->id;
    $service->name = $newitem->name;
    $service->description = $newitem->description;
    $service->price = $newitem->price;
    $service->path_to_image = $newitem->path_to_image;
    $service->is_new = $newitem->is_new;
    $service->is_discount = $newitem->is_discount;
    $service->old_price = $newitem->old_price;
    $service->category_id = $newitem->category_id;
    $service->quantity = $newitem->quantity;
    array_push($models, $service);
}

$idArray = array();
foreach($models as $item) {
    $id = $item->getUniqueId();
    array_push($idArray, $id);
}
foreach ($models as $val) {
    foreach($idArray as $val2) {
        if ($val->getUniqueId() == $val2) {
            $duplicateCounts = array_count_values($idArray);
            $val->setQuantity($duplicateCounts[$val2]);
            //unset($items[array_search($val2, $items)]);
        }
    }
}
$models = array_unique($models, SORT_REGULAR);


$cartDataProvider->setModels($models);
    

?>

<div class="pdf-dealer container">
    <h4 class='text-center'>Rēķins nr. <?=$model->id?></h4>
    <br>
    <table class="table table-borderless">
        <tbody>
        <tr style="border:0">
                <td style="width:25%">Izsniegšanas datums:</td>
                <td style="width:75%"><b><?=datefmt_format($fmt, time())?></b></td>
            </tr>
            <tr style="border:0">
                <td style="width:25%"></td>
                <td style="width:75%"></td>
            </tr>
            <tr style="border:0">
                <td style="width:25%">Pakalpojumu sniedzējs:</td>
                <td style="width:75%"><b>Testa biedrība</b></td>
            </tr>
            <tr style="border:0">
                <td style="width:25%">Adrese:</td>
                <td style="width:75%"><b>Irbenāju iela 13, Skulte, Skultes pagasts, Limbažu novads, Latvija, LV-2169</b></td>
            </tr>
            <tr style="border:0">
                <td style="width:25%">Norēķinu konta numurs:</td>
                <td style="width:75%"><b>ASDFSDAF13451235</b></td>
            </tr>
        </tbody>
    </table>
    <hr />
    <table class="table table-borderless">
        <tbody>
            <tr style="border:0">
                <td style="width:25%">Pakalpojumu saņēmējs:</td>
                <td style="width:75%"><b><?= $model->name . ' ' . $model->surname?></b></td>
            </tr>
            <tr style="border:0">
                <td style="width:25%">Adrese:</td>
                <td style="width:75%"><b><?=$model->address?></b></td>
            </tr>
        </tbody>
    </table>
    <hr />
    <table class="table table-borderless">
        <tbody>
            <tr style="border:0">
                <td style="width:25%">Apmaksas veids:</td>
                <td style="width:75%"><b>Pārskaitījums</b></t>
            </tr>
        </tbody>
    </table>
<?php

$total = number_format(Service::getAttributeTotal("price", $models), 2);

echo \yii2mod\cart\widgets\CartGrid::widget([
    // Some widget property maybe need to change. 
    'cartDataProvider' => $cartDataProvider,
    'cartColumns' => [
        ['class' => 'yii\grid\SerialColumn'],
        
        [
            'label' => \Yii::t('frontend', 'serviceName'),
            'value' => function ($model) {
                return $model->getLabel();
            }
          ],
        
        [
            'label' => \Yii::t('frontend', 'servicePrice'),
            'value' => function ($model) {
                return $model->getPrice();
            }
          ],
        [
            'label' => \Yii::t('frontend', 'serviceQuantity'),
            'value' => function ($model) {
                return $model->getQuantity();
            }
          ],
        'invoice',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{myButton}',  // the default buttons + your custom button
            'buttons' => [
                'myButton' => function($url, $model, $key) {     // render your custom button
                    return Html::a(
                        '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"/></svg>',
                        '#',
                        ['class' => 'remove-from-cart', 'title' => 'Dzēst', 'data-pjax' => 0, 'value' => $model->id]
                    );
                }
            ]
        ]
    ]
]);

?> <br><p>Summa apmaksai vārdiem:&nbsp;<b><?php echo convert_number_to_latvian_words(floor($total)) . " eiro, " . convert_number_to_latvian_words(ceil(($total - floor($total)) * 100)) . " centi"?></b> </p>
<br>
<p>Izsniedza:&nbsp;<b>Ilona Lūsēna</b></p>
<br>
<p><b>Rēķins ir izrakstīts elektroniski un ir derīgs bez paraksta</b></p>
<?php

function convert_number_to_latvian_words($num)
{
	if ( ! is_numeric($num))
		return false;

	if (($num >= 0 && (int) $num < 0) OR (int) $num < 0 - PHP_INT_MAX) {
		// overflow
		trigger_error('convert_number_to_latvian_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING);
		return false;
	}

	$dict = [
		0 => 'nulle',
		1 => 'viens',
		2 => 'divi',
		3 => 'trīs',
		4 => 'četri',
		5 => 'pieci',
		6 => 'seši',
		7 => 'septiņi',
		8 => 'astoņi',
		9 => 'deviņi',
		10 => 'desmit',
		11 => 'vienpadsmit',
		12 => 'divpadsmit',
		13 => 'trīspadsmit',
		14 => 'četrpadsmit',
		15 => 'piecpadsmit',
		16 => 'sešpadsmit',
		17 => 'septiņpadsmit',
		18 => 'astoņpadsmit',
		19 => 'deviņpadsmit',
		20 => 'divdesmit',
		30 => 'trīsdesmit',
		40 => 'četrdesmit',
		50 => 'piecdesmit',
		60 => 'sešdesmit',
		70 => 'septiņdesmit',
		80 => 'astoņdesmit',
		90 => 'deviņdesmit',
		100 => 'simts',
		1000 => 'tūkstotis',
		1000000 => 'miljons',
		1000000000 => 'miljards',
    ];

	$pre = [
		1 => 'vien',
		2 => 'div',
		3 => 'trīs',
		4 => 'četr',
		5 => 'piec',
		6 => 'seš',
		7 => 'septiņ',
		8 => 'astoņ',
		9 => 'deviņ',
    ];

	if ($num < 0) {
		return 'mīnus '.convert_number_to_latvian_words(abs($num));
	}

	switch ($num) {
		case 0:
		case 100:
		case 1000:
		case 1000000:
		case 1000000000:
			return $dict[$num];
	}

	if ($num < 21) {
		return $dict[$num];
	}

	if ($num < 100) {
		$x10 = ((int) ($num / 10)) * 10;
		$rem = $num % 10;

		$str = $dict[$x10];

		if ($rem > 0) {
			$str .= ' '.$dict[$rem];
		}

		return $str;
	}

	if ($num < 1000) {
		$x100 = intval($num / 100);
		$rem = $num % 100;

		$str = ($x100 === 1 ? 'simtu' : $pre[$x100].'simt');

		if ($rem > 0) {
			$str .= ' '.convert_number_to_latvian_words($rem);
		}

		return $str;
	}

	if ($num < 1000000) {
		$val = intval($num / 1000);
		$rem = $num % 1000;

		$str = convert_number_to_latvian_words($val);
		$str .= ($val === 1 ? ' tūkstotis' : ' tūkstoši');

		if ($rem > 0) {
			$str .= ' '.convert_number_to_latvian_words($rem);
		}

		return $str;
	}

	throw new Exception('Maximum number that can be converted to words exceeded');
}

?>