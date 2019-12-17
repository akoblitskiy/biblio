<?php
spl_autoload_register(function ($class) {
    if ($tokens = preg_split("/[\\\\]+/", $class)) {
        $fullClassname = implode('/', $tokens);
        include_once '../' . lcfirst($fullClassname) . '.php';
    }
});