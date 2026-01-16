<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use common\models\User;
use yii\helpers\Url;
use kartik\sidenav\SideNav;

AppAsset::register($this);
$searchUrl = Url::toRoute('site/search');
$rows = (new \yii\db\Query())
    ->select(['id'])
    ->from('order')
    ->where(['status' => 0])
    //->orderBy(['price' => $order])
    ->all();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
    <?php $this->registerJsFile('/assets/97d0f90c/custom.js', ['depends' => [yii\web\JqueryAsset::className()]]);?>
    <?php //$this->registerJsFile('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', ['depends' => [yii\web\JqueryAsset::className()]]);?>
    <?php $this->registerJsFile('https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js', ['depends' => [yii\web\JqueryAsset::className()]]);?>
    <?php $this->registerJsFile('https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js', ['depends' => [yii\web\JqueryAsset::className()]]);?>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <div class="page-header">
        <div class="lang">
            <?php if (isset(Yii::$app->user->identity->username)) { ?>
                <div id="logout" class="float-end">
                <?= Html::a('Logout', ['/site/logout'], ['class' => 'text-white', 'data-method' => 'post']) ?>
            </div>
            <?php } ?>
            
            <?= Html::a('latviski', ['/site/index', 'language' => 'lv'], ['class' => 'text-white']) ?>
            <br>
            <?= Html::a('по-русски', ['/site/index', 'language' => 'ru'], ['class' => 'text-white']) ?>
        </div>
        <h1 class="text-white">My awesome page header</h1>
        <div id="search">
            <form action="<?=$searchUrl?>" method="post" class="d-flex">
            <?= \yii\helpers\Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->getCsrfToken());?>
            <input class="form-control me-2" type="text" name="searchParam" placeholder="Search" aria-label="Search">
            <button class="btn btn-primary" type="submit" name="foo" value="bar">Search</button>
            </form>
        </div>
    </div>

    <?php
    NavBar::begin([
        //'brandLabel' => Yii::$app->name,
        //'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
        ['label' => 'Catalog', 'url' => ['/catalog']],
        ['label' => 'Blog', 'url' => ['/blog']],
        //['label' => \Yii::t('frontend','cart'), 'url' => ['/site/cart']],
    ];
    if (isset(Yii::$app->user->identity->username) && User::isUserAdmin(Yii::$app->user->identity->username)) {
        $menuItems[] = [
            'label' => \Yii::t('frontend', 'admin'),
            'url' => '#',
            'items' => [
                ['label' => \Yii::t('frontend', 'categories_services'), 'url' => ['/category/index']],
                ['label' => \Yii::t('frontend', 'services'), 'url' => ['/service/index']],
                sprintf('<a class="dropdown-item" href="/order/index">%s <span class="badge bg-primary rounded-pill" style="float:right">' . count($rows) . '</span></a>', Yii::t('frontend', 'orders')),
                ['label' => \Yii::t('frontend', 'posts'), 'url' => ['post/index']],
            ],
        ];
    }

    // echo SideNav::widget([
    //          'items' => [
    //              [
    //                  'url' => ['/site/index'],
    //                  'label' => 'Home',
    //                  'icon' => 'home'
    //              ],
    //              [
    //                  'url' => ['/site/about'],
    //                  'label' => 'About',
    //                  'icon' => 'info-sign',
    //                  'items' => [
    //                       ['url' => '#', 'label' => 'Item 1'],
    //                       ['url' => '#', 'label' => 'Item 2'],
    //                  ],
    //              ],
    //          ],
    //      ]);

    // echo SideNav::widget([
    //     'type' => SideNav::TYPE_DEFAULT,
    //     'encodeLabels' => false,
    //     'heading' => '<i class="fas fa-cog"></i> Operations',
    //     'items' => $menuItems,
    // ]);        

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);

    ?> <?php
    //if (Yii::$app->user->isGuest) {
        //echo "&#124;";
        echo Html::tag('div',Html::a(\Yii::t('frontend','cart'),['/site/cart'],['class' => ['text-decoration-none cart']]),['class' => ['d-flex']]);
    //} else {
    //    echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
    //        . Html::submitButton(
    //            'Logout (' . Yii::$app->user->identity->username . ')',
     //           ['class' => 'btn btn-link logout text-decoration-none']
      //      )
      //      . Html::endForm();
    //}
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-end">Made by: BE Dev</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
