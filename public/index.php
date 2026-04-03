<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Vendor\App\Core\Logger;
use Vendor\App\Facade\Route;

$dotenv = Dotenv::createUnsafeImmutable(dirname(__DIR__));
$dotenv->load();

$constants = require_once __DIR__ . '/../config/constant.php';
foreach ($constants as $key => $value) {
    define($key, $value);
}

set_exception_handler(function ($e) {
    Logger::error($e->getMessage(), [
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
    echo "Something Went Wrong. Please try again";
});

require_once __DIR__ . '/../routes/web.php';

Route::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);