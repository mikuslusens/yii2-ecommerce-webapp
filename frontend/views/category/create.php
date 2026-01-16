<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Category $model */

$this->title = Yii::t('frontend', 'Create Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
