<?php

use yii\helpers\Url;

$fmt = datefmt_create(
    'lv_LV',
    IntlDateFormatter::LONG,
    IntlDateFormatter::NONE,
);

$rows = (new \yii\db\Query())
->select(['id', 'title', 'author', 'content', 'date'])
->from('post')
->orderBy(['date' => SORT_DESC])
->all();

$this->title = Yii::t('frontend', 'blog');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <h1><?=$this->title?></h1>
    <hr>
    
    <?php if(count($rows) > 0)
    {

    

        foreach($rows as $key => $post) {?>
            <div class="row">
                <div class="col col-sm-12">
                    <h3><a class="post-header" href="<?=Url::toRoute('blog/post') . "?id=" . $post["id"]?>"><?=$post['title']?></a></h3>
                    <p><?=Yii::t('frontend', 'date') . ": " . datefmt_format($fmt, strtotime($post['date'])) ?></p>
                    <p><?=Yii::t('frontend', 'author') . ": " . $post['author'] ?></p>
                    <p><?=strlen($post['content']) > 300 ? substr($post['content'],0,300)."..." : $post['content'] ?></p>
                </div>
            </div>

    <?php } } ?>
</div>