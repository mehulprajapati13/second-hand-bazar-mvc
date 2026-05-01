<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<div id="accountSidebar" class="bg-white border border-gray-100 rounded-2xl py-6 shadow-sm transition-all duration-300 h-full">
    <!-- Mobile Toggle -->
    <div class="px-4 lg:hidden mb-4">
        <button onclick="document.getElementById('sidebarNav').classList.toggle('hidden')" class="w-full flex items-center justify-between p-3 bg-gray-50 rounded-xl text-gray-700 font-semibold border border-gray-200">
            <span>Dashboard Menu</span>
            <i class="bi bi-list text-xl"></i>
        </button>
    </div>

    <div id="sidebarNav" class="hidden lg:block">
        <div class="px-6 mb-4 flex justify-between items-center">
            <h6 class="font-bold text-xs uppercase tracking-wider text-gray-400 m-0 sidebar-text">My Account</h6>
            <button onclick="toggleSidebar()" class="hidden lg:block text-gray-400 hover:text-orange-500 transition-colors focus:outline-none" title="Toggle Sidebar">
                <i class="bi bi-arrow-bar-left text-lg" id="sidebarToggleIcon"></i>
            </button>
        </div>
        
        <nav class="flex flex-col gap-1 px-3">
            <a href="/dashboard" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?= str_starts_with($currentPath, '/dashboard') ? 'bg-orange-50 text-orange-600 font-bold shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' ?> no-underline" title="Overview">
                <i class="bi bi-grid-1x2 text-xl <?= str_starts_with($currentPath, '/dashboard') ? 'text-orange-500' : 'text-gray-400 group-hover:text-orange-500' ?>"></i>
                <span class="sidebar-text text-sm whitespace-nowrap">Overview</span>
            </a>
            
            <a href="/items" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?= str_starts_with($currentPath, '/items') && !str_starts_with($currentPath, '/items/add') ? 'bg-orange-50 text-orange-600 font-bold shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' ?> no-underline" title="My Listings">
                <i class="bi bi-box-seam text-xl <?= str_starts_with($currentPath, '/items') && !str_starts_with($currentPath, '/items/add') ? 'text-orange-500' : 'text-gray-400 group-hover:text-orange-500' ?>"></i>
                <span class="sidebar-text text-sm whitespace-nowrap">My Listings</span>
            </a>
            
            <a href="/requests" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?= str_starts_with($currentPath, '/requests') ? 'bg-orange-50 text-orange-600 font-bold shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' ?> no-underline" title="Requests">
                <i class="bi bi-chat-left-dots text-xl <?= str_starts_with($currentPath, '/requests') ? 'text-orange-500' : 'text-gray-400 group-hover:text-orange-500' ?>"></i>
                <span class="sidebar-text text-sm whitespace-nowrap">Requests</span>
                <?php if (isset($summary['requests_received']) && $summary['requests_received'] > 0): ?>
                    <span class="sidebar-text ml-auto bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full"><?= $summary['requests_received'] ?></span>
                <?php endif; ?>
            </a>
            
            <a href="/profile" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?= str_starts_with($currentPath, '/profile') ? 'bg-orange-50 text-orange-600 font-bold shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' ?> no-underline" title="Profile Settings">
                <i class="bi bi-person text-xl <?= str_starts_with($currentPath, '/profile') ? 'text-orange-500' : 'text-gray-400 group-hover:text-orange-500' ?>"></i>
                <span class="sidebar-text text-sm whitespace-nowrap">Profile Settings</span>
            </a>

            <a href="/browse" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?= str_starts_with($currentPath, '/browse') ? 'bg-orange-50 text-orange-600 font-bold shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' ?> no-underline" title="Browse Items">
                <i class="bi bi-search text-xl <?= str_starts_with($currentPath, '/browse') ? 'text-orange-500' : 'text-gray-400 group-hover:text-orange-500' ?>"></i>
                <span class="sidebar-text text-sm whitespace-nowrap">Browse Items</span>
            </a>
        </nav>

        <hr class="border-gray-100 my-4 mx-6">

        <div class="px-3">
            <a href="/logout" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-red-600 hover:bg-red-50 no-underline font-semibold" title="Sign Out">
                <i class="bi bi-box-arrow-right text-xl text-red-400 group-hover:text-red-500"></i>
                <span class="sidebar-text text-sm whitespace-nowrap">Sign Out</span>
            </a>
        </div>
    </div>
</div>

<script>
    function toggleSidebar() {
        const texts = document.querySelectorAll('.sidebar-text');
        const icon = document.getElementById('sidebarToggleIcon');
        const isCollapsed = icon.classList.contains('bi-arrow-bar-right');
        
        texts.forEach(el => {
            if (isCollapsed) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        });
        
        if (isCollapsed) {
            icon.classList.replace('bi-arrow-bar-right', 'bi-arrow-bar-left');
        } else {
            icon.classList.replace('bi-arrow-bar-left', 'bi-arrow-bar-right');
        }
        
        // Find parent column and adjust it if we are on desktop
        const parentCol = document.getElementById('accountSidebar').closest('[class*="col-lg-"]');
        if (parentCol) {
            if (isCollapsed) {
                parentCol.classList.replace('col-lg-1', 'col-lg-3');
                parentCol.nextElementSibling.classList.replace('col-lg-11', 'col-lg-9');
            } else {
                parentCol.classList.replace('col-lg-3', 'col-lg-1');
                parentCol.nextElementSibling.classList.replace('col-lg-9', 'col-lg-11');
            }
        }
    }
</script>
