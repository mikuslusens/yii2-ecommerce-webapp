<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/../config/main.php';  // ← This loads the merged config
$db = $config['components']['db'];
echo "Trying: " . $db['username'] . "@" . $db['dsn'] . "<br>";
try {
    $conn = new PDO($db['dsn'], $db['username'], $db['password']);
    echo "Connected!";
} catch (Exception $e) {
    echo "Failed: " . $e->getMessage();
}