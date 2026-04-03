<?php 
define('BASE_PATH', dirname(__DIR__));

return [
    'MAIL_HOST' => $_ENV['MAIL_HOST'] ?? 'sandbox.smtp.mailtrap.io',
    'MAIL_PORT' => $_ENV['MAIL_PORT'] ?? 2525,
    'MAIL_USERNAME' => $_ENV['MAIL_USERNAME'] ?? '',
    'MAIL_PASSWORD' => $_ENV['MAIL_PASSWORD'] ?? '',
    'MAIL_FROM_ADDRESS' => $_ENV['MAIL_FROM_ADDRESS'] ?? 'noreply@secondhandbazaar.com',
    'MAIL_FROM_NAME' => $_ENV['MAIL_FROM_NAME'] ?? 'Second Hand Bazaar',
];