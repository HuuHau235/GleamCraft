<?php

// Tự động load các class
spl_autoload_register(function ($class) {
    $classPath = str_replace('\\', '/', $class) . '.php';
    $filePath = __DIR__ . '/../' . $classPath;

    if (file_exists($filePath)) {
        require_once $filePath;
    } else {
        die("File not found: $filePath");
    }
});
