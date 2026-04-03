<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SecondHand Bazaar</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ["DM Sans","sans-serif"] },
                    colors: {
                        brand: { 50:'#fff7ed',100:'#ffedd5',400:'#fb923c',500:'#f97316',600:'#ea580c',700:'#c2410c' }
                    }
                }
            }
        };
    </script>
    <style>
        .sidebar-link { transition: background .15s, color .15s; }
        .sidebar-link.active { background-color: rgba(249,115,22,.12); color: #ea580c; border-right: 3px solid #f97316; }
        .sidebar-link:not(.active):hover { background-color: rgba(0,0,0,.04); }
        [x-cloak] { display:none; }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$sidebarItems = [
    ['label'=>'Dashboard',    'href'=>'/dashboard', 'match'=>'/dashboard',
     'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
    ['label'=>'Browse Items', 'href'=>'/browse',    'match'=>'/browse',
     'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>'],
    ['label'=>'My Listings',  'href'=>'/items',  'match'=>'/items',
     'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>'],
    ['label'=>'Requests',     'href'=>'/requests',  'match'=>'/requests',
     'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>'],
    ['label'=>'Profile',      'href'=>'/profile',   'match'=>'/profile',
     'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
];
$userName    = trim($_SESSION['user']['name'] ?? 'User');
if ($userName === '') $userName = 'User';
$userInitial = strtoupper(substr($userName, 0, 1));
?>

<div class="min-h-screen flex">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="hidden lg:flex lg:flex-col w-60 bg-white border-r border-gray-200 fixed top-0 left-0 h-full z-30">
        <!-- Logo -->
        <div class="px-5 py-4 border-b border-gray-100">
            <a href="/" class="flex items-center gap-2">
                <div class="h-8 w-8 rounded-lg bg-brand-500 flex items-center justify-center flex-shrink-0">
                    <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0v4a1 1 0 001 1h1M9 21a1 1 0 110-2 1 1 0 010 2zm8 0a1 1 0 110-2 1 1 0 010 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900 leading-tight">SecondHand<span class="text-brand-500">Bazaar</span></p>
                    <p class="text-xs text-gray-400">Marketplace</p>
                </div>
            </a>
        </div>

        <!-- User Info -->
        <div class="px-5 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-full bg-brand-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    <?= htmlspecialchars($userInitial) ?>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate"><?= htmlspecialchars($userName) ?></p>
                    <p class="text-xs text-gray-500 truncate"><?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?></p>
                </div>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Menu</p>
            <?php foreach ($sidebarItems as $navItem):
                $isActive = str_starts_with($currentPath, $navItem['match']);
                $cls = $isActive ? 'sidebar-link active font-semibold text-brand-600' : 'sidebar-link text-gray-600';
            ?>
            <a href="<?= $navItem['href'] ?>" class="<?= $cls ?> flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm">
                <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <?= $navItem['icon'] ?>
                </svg>
                <?= htmlspecialchars($navItem['label']) ?>
            </a>
            <?php endforeach; ?>
        </nav>

        <!-- Actions -->
        <div class="px-3 py-4 border-t border-gray-100 space-y-2">
            <a href="/items/add" class="flex items-center justify-center gap-2 w-full bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold py-2.5 rounded-lg transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                New Listing
            </a>
            <a href="/logout" class="flex items-center justify-center gap-2 w-full border border-gray-200 text-gray-600 hover:text-red-600 hover:border-red-200 hover:bg-red-50 text-sm font-medium py-2.5 rounded-lg transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </a>
        </div>
    </aside>

    <!-- MAIN AREA -->
    <div class="flex-1 flex flex-col lg:ml-60">

        <!-- TOP NAV -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-20 shadow-sm">
            <div class="px-4 sm:px-6 py-3 flex items-center justify-between gap-4">
                <!-- Mobile logo + hamburger -->
                <div class="flex items-center gap-3">
                    <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="lg:hidden p-1.5 rounded-lg text-gray-500 hover:bg-gray-100">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div class="lg:hidden">
                        <p class="text-sm font-bold text-gray-900">SecondHand<span class="text-brand-500">Bazaar</span></p>
                    </div>
                </div>

                <!-- Search -->
                <form action="/browse" method="GET" class="hidden sm:flex flex-1 max-w-md">
                    <div class="flex w-full border border-gray-300 rounded-lg overflow-hidden hover:border-brand-400 transition-colors">
                        <input type="text" name="search" placeholder="Search listings..."
                            class="flex-1 px-3 py-2 text-sm border-none focus:outline-none focus:ring-0 bg-gray-50" />
                        <button type="submit" class="px-3 bg-gray-50 border-l border-gray-300 text-gray-400 hover:text-brand-500 hover:bg-gray-100 transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>
                </form>

                <!-- Right Actions -->
                <div class="flex items-center gap-2">
                    <a href="/items/add" class="hidden sm:inline-flex items-center gap-1.5 bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors shadow-sm">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        List Item
                    </a>

                    <!-- User dropdown -->
                    <details class="relative">
                        <summary class="flex items-center gap-2 cursor-pointer list-none px-2 py-1.5 rounded-lg hover:bg-gray-100 transition-colors" style="list-style:none">
                            <div class="h-8 w-8 rounded-full bg-brand-500 flex items-center justify-center text-white font-bold text-xs">
                                <?= htmlspecialchars($userInitial) ?>
                            </div>
                            <span class="hidden sm:block text-sm font-medium text-gray-700 max-w-[100px] truncate"><?= htmlspecialchars($userName) ?></span>
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/></svg>
                        </summary>
                        <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-xl shadow-xl py-1 z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-xs font-semibold text-gray-900 truncate"><?= htmlspecialchars($userName) ?></p>
                                <p class="text-xs text-gray-500 truncate"><?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?></p>
                            </div>
                            <a href="/profile" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Edit Profile
                            </a>
                            <a href="/logout" class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Logout
                            </a>
                        </div>
                    </details>
                </div>
            </div>
        </header>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white border-b border-gray-200 px-4 py-3 space-y-1">
            <?php foreach ($sidebarItems as $navItem):
                $isActive = str_starts_with($currentPath, $navItem['match']);
                $cls = $isActive ? 'bg-brand-50 text-brand-600 font-semibold' : 'text-gray-600 hover:bg-gray-50';
            ?>
            <a href="<?= $navItem['href'] ?>" class="<?= $cls ?> flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors">
                <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><?= $navItem['icon'] ?></svg>
                <?= htmlspecialchars($navItem['label']) ?>
            </a>
            <?php endforeach; ?>
            <div class="pt-2 border-t border-gray-100 flex gap-2">
                <a href="/items/add" class="flex-1 text-center bg-brand-500 text-white text-sm font-semibold py-2 rounded-lg">+ List Item</a>
                <a href="/logout" class="flex-1 text-center border border-gray-200 text-gray-600 text-sm py-2 rounded-lg">Logout</a>
            </div>
        </div>

        <!-- PAGE CONTENT START -->
        <div class="flex-1 pb-10">
