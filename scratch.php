<?php
function getRealImage($filename) {
    if (empty($filename)) return '';
    $base = pathinfo($filename, PATHINFO_FILENAME);
    $dir = __DIR__ . '/public/uploads/items/';
    if (file_exists($dir . $filename)) return $filename;
    
    $exts = ['webp', 'avif', 'jpg', 'jpeg', 'png'];
    foreach ($exts as $ext) {
        if (file_exists($dir . $base . '.' . $ext)) {
            return $base . '.' . $ext;
        }
    }
    return $filename; 
}
echo getRealImage('item_69cf8c8009c159.94638573.jpg');
echo "\n";
echo getRealImage('item_69d0b35d392865.08023076.png');
