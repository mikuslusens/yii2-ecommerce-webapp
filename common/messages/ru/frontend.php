<?php

$cart = \Yii::$app->cart;

return[

    // Menu texts

    'contact'=>'zdrastvuj',
    'cart' => 'Pirkumskij grozik <i class="fa-solid fa-cart-shopping"></i></i> ' . $cart->getCount(),
    'cart2' => 'Pirkumskij grozik',
    'admin' => 'Administracija',
    'categories_products' => 'Prečskije kategoriki',
    'products' => 'Preciki',
    'categories_services' => 'Pakalpojumskije kategoriki',
    'services' => 'Pakalpojumiki',
    'order' => 'Pasutiķ',
    'choose_category' => 'Izveliķe kategoriju...',
    'add_category' => 'Pievienoķiķ kategoriju',
    'add_service' => 'Pievienoķiķ pakalpojumu',
    'catalog' => 'Katalog',
    'create_order' => 'Noformetiķ pasutijumiku',
    'orders' => 'Pasūtījumi',
    'received' => 'Saņemts',
    'paid' => 'Apmaksāts',
    'delivered' => 'Piegādāts',
    'serviceName' => 'Pakalpojuma nosaukums',
    'servicePrice' => 'Cena (EUR)',
    'serviceQuantity' => 'Daudzums',
    'invoiceTotal' => 'Kopā (EUR)',
    'search_results' => 'Meklēšanas rezultāti',
    'blog' => 'Blog',
    'posts' => 'Blogije ieraksti',
    'date' => 'Datumik',
    'author' => 'Avtor',
];
