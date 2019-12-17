<?php

$config = require 'config/load.php';
if ($config['env'] == 'dev') {
    ini_set('display_errors', 'On');
}

include 'src/autoload.php';
use MVCFramework\App;
use MVCFramework\Request;

$app = new App($config);
$app->run($config);