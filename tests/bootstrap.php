<?php

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\ErrorHandler;

require dirname(__DIR__) . '/vendor/autoload.php';

ErrorHandler::register(null, false);

if (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');
}
$appEnv = $_SERVER['APP_ENV'];
$kernelClass = $_SERVER['KERNEL_CLASS'];

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}
