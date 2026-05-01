<?php
return [
    'host' => $_ENV['DB_HOST'] ?? 'localhost',
    'user' => $_ENV['DB_USER'] ?? 'root',
    'pass' => $_ENV['DB_PASS'] ?? '',
    'dbname' => $_ENV['DB_NAME'] ?? 'second_hand_bazar_db',
    'port' => $_ENV['DB_PORT'] ?? '3306',
];
