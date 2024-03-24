<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    // project-specific namespace prefix
    $prefix = 'App';

    // base directory for the namespace prefix
    $base_dir = str_replace(['\Core\Autoload', '/Core/Autoload'], '', __DIR__);

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }
    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . '/src' . str_replace('\\', '/', $relative_class) . '.php';

    var_dump($base_dir);
    var_dump($file);

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});
