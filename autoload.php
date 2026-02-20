<?php
//Autoload
spl_autoload_register(function ($class_name) {
    $base_dir = __DIR__ . '/classes/';
    $file = $base_dir . $class_name . '.class.php';

    if (file_exists($file)) {
        require_once $file;
    } else {

    }
});