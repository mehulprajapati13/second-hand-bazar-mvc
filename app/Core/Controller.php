<?php

namespace Vendor\App\Core;

class Controller
{
    protected function view(string $path, array $data = [])
    {
        extract($data);
        require __DIR__ . "/../Views/$path.php";
    }
    protected function log(string $message, array $context = [])
    {
        Logger::error($message, $context);
    }
}
