<?php
return [
    'services' =>
    [
        'database' => require 'database.php'
    ],
    'controllers' => [ 'namespace' => 'Src\\Controller\\' ],
    'pagination' => [ 'count' => 10 ]
];