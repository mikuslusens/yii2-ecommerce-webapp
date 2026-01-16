<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'bsVersion' => '5.x',
    'urlRules' => [
       '' => 'site/index',
       'login/' => 'site/login',
       'signup/' => 'site/signup',
       '<controller:[\w-]+>/<action:\w+>' => '<controller>/<action>',
       '<controller:[\w-]+>/<id:\d+>' => '<controller>/view',
       '<controller:[\w-]+>/create' => '<controller>/create',
       '<controller:[\w-]+>/update/<id:\d+>' => '<controller>/update',
       '<controller:[\w-]+>/delete/<id:\d+>' => '<controller>/delete',
       '<controller:[\w-]+>/bulk-delete' => '<controller>/bulk-delete',
    ],
];
