<?php

$fmt = datefmt_create(
    'lv_LV',
    IntlDateFormatter::LONG,
    IntlDateFormatter::NONE,
);

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'blog'), 'url' => ['blog/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col col-sm-12">
        <h3><?=$model->title?></h3>
        <p><?=Yii::t('frontend', 'date') . ": " . datefmt_format($fmt, strtotime($model->date)) ?></p>
        <p><?=Yii::t('frontend', 'author') . ": " . $model->author ?></p>
        <p><?=$model->content ?></p>
    </div>
</div>
