<?php

$config = require '../config/load.php';
if ($config['env'] == 'dev') {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL & ~E_NOTICE);
}
require '../core/autoload.php';
use Core\App;

$app = new App($config);
$app->run($config);