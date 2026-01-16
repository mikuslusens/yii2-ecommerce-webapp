<?php

$cart = \Yii::$app->cart;

return[

    // Menu texts

    'contact'=>'Saziņa',
    'cart' => 'Izvēlētie pakalpojumi: ' . $cart->getCount(),
    'cart2' => 'Izvēlētie pakalpojumi',
    'admin' => 'Administrācija',
    'categories_products' => 'Preču kategorijas',
    'products' => 'Preces',
    'categories_services' => 'Pakalpojumu kategorijas',
    'services' => 'Pakalpojumi',
    'order' => 'Pasūtīt',
    'choose_category' => 'Izvēlēties kategoriju...',
    'add_category' => 'Pievienot kategoriju',
    'add_service' => 'Pievienot pakalpojumu',
    'catalog' => 'Katalogs',
    'create_order' => 'Noformēt pasūtījumu',
    'orders' => 'Pasūtījumi',
    'received' => 'Saņemts',
    'paid' => 'Apmaksāts',
    'delivered' => 'Piegādāts',
    'serviceName' => 'Pakalpojuma nosaukums',
    'servicePrice' => 'Cena (EUR)',
    'serviceQuantity' => 'Daudzums',
    'invoiceTotal' => 'Kopā (EUR)',
    'search_results' => 'Meklēšanas rezultāti',
    'blog' => 'Blogs',
    'posts' => 'Bloga ieraksti',
    'date' => 'Datums',
    'author' => 'Autors',
];  

