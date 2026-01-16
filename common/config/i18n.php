<?php
return [
    'sourcePath' => '/var/www/bode',
    'languages' => ['lv-LV', 'ru-RU'], //Add languages to the array for the language files to be generated, here are English and Russian.
    'translator' => 'Yii::t',
    'sort' => false,
    'removeUnused' => false,
    'only' => ['*.php'],
    'except' => [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '.hgignore',
        '.hgkeep',
        '/messages',
        '/vendor',
    ],
    'format' => 'php',
    'messagePath' => '/var/www/bode/common/messages', //path of messages folder created above
    'overwrite' => true,
];
