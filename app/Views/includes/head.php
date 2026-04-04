<?php
$siteName = 'SecondHand Bazaar';
$page = trim((string)($pageTitle ?? ''));
$fullTitle = $page !== '' ? ($page . ' | ' . $siteName) : ($siteName . ' | Buy & Sell Pre-Owned Items');

// Build asset path that works for both /index.php and /public/index.php setups.
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
$scriptDir = str_replace('\\', '/', dirname($scriptName));
$scriptDir = ($scriptDir === '/' || $scriptDir === '\\') ? '' : rtrim($scriptDir, '/');
$assetPrefix = '';
if ($scriptDir !== '') {
    $assetPrefix = (substr($scriptDir, -7) === '/public') ? $scriptDir : ($scriptDir . '/public');
}
$customCss = $assetPrefix . '/assets/css/custom.css';

$cssFile = dirname(__DIR__, 3) . '/public/assets/css/custom.css';
$cssVersion = is_file($cssFile) ? (string)filemtime($cssFile) : (string)time();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($fullTitle, ENT_QUOTES, 'UTF-8') ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= htmlspecialchars($customCss, ENT_QUOTES, 'UTF-8') . '?v=' . urlencode($cssVersion) ?>" rel="stylesheet">
</head>

<body>