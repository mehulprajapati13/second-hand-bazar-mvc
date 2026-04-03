<?php

namespace Vendor\App\Core;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Level;

class Logger
{
    private static ?MonologLogger $instance = null;

    private function __construct() {}

    public static function getInstance(): MonologLogger
    {
        if (self::$instance === null) {
            self::$instance = self::build();
        }
        return self::$instance;
    }

    private static function build(): MonologLogger
    {
        $levelName = strtolower($_ENV['LOG_LEVEL'] ?? 'debug');
        $level = Level::fromName($levelName);

        $formatter = new LineFormatter(
            "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
            'Y-m-d H:i:s', true, true
        );

        $logPath = __DIR__ . '/../../storage/logs/app.log';
        $handler = new StreamHandler($logPath, $level);
        $handler->setFormatter($formatter);

        $logger = new MonologLogger('app');
        $logger->pushHandler($handler);

        return $logger;
    }

    public static function error(string $message, array $context = []): void
    {
        self::getInstance()->error($message, $context);
    }
}