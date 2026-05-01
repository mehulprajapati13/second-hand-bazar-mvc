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
$customCss = $assetPrefix . '/assets/css/app.css';

$cssFile = dirname(__DIR__, 3) . '/public/assets/css/app.css';
$cssVersion = is_file($cssFile) ? (string)filemtime($cssFile) : (string)time();

if (!function_exists('getRealImage')) {
    function getRealImage($filename) {
        if (empty($filename)) return '';
        $base = pathinfo($filename, PATHINFO_FILENAME);
        $dir = dirname(__DIR__, 3) . '/public/uploads/items/';
        if (file_exists($dir . $filename)) return $filename;
        
        $exts = ['webp', 'avif', 'jpg', 'jpeg', 'png'];
        foreach ($exts as $ext) {
            if (file_exists($dir . $base . '.' . $ext)) {
                return $base . '.' . $ext;
            }
        }
        return $filename; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Buy and sell quality pre-owned items locally. SecondHand Bazaar connects verified buyers and sellers in your city.">
    <title><?= htmlspecialchars($fullTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🛒</text></svg>">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: { preflight: false },
            theme: {
                extend: {
                    colors: { primary: '#f97316' }
                }
            }
        }
    </script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= htmlspecialchars($customCss, ENT_QUOTES, 'UTF-8') . '?v=' . urlencode($cssVersion) ?>" rel="stylesheet">
</head>

<body>