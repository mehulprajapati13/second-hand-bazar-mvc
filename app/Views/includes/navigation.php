<?php
$isLoggedIn = isset($_SESSION['user']);
$userName = trim($_SESSION['user']['name'] ?? 'User');
if ($userName === '') $userName = 'User';
$userEmail = $_SESSION['user']['email'] ?? '';
$userInitial = strtoupper(substr($userName, 0, 1));
$userRole = $_SESSION['user']['role'] ?? 'user';
?>
<!-- Unified E-commerce Navigation -->
<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100 shadow-sm py-3 transition-all duration-300">
    <div class="container mx-auto px-4 flex items-center justify-between">
        <!-- Logo -->
        <a class="flex items-center gap-3 no-underline me-4" href="/">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-400 to-orange-600 text-white flex items-center justify-center text-xl shadow-lg shadow-orange-500/30">
                <i class="bi bi-bag-heart-fill"></i>
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-extrabold tracking-tight text-gray-900 leading-none">SecondHand<span class="text-orange-500">Bazaar</span></span>
                <span class="text-[0.6rem] font-bold text-gray-400 tracking-[0.15em] mt-1">MARKETPLACE</span>
            </div>
        </a>

        <!-- Mobile Toggles -->
        <div class="flex items-center gap-3 lg:hidden">
            <?php if ($isLoggedIn): ?>
                <a href="/items/add" class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center"><i class="bi bi-plus-lg text-lg"></i></a>
            <?php endif; ?>
            <button class="navbar-toggler border-0 shadow-none px-2 text-gray-700" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <i class="bi bi-list text-2xl"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse lg:!flex lg:items-center lg:justify-between w-full" id="mainNav">
            
            <!-- Global Search Bar (Center) -->
            <form action="/browse" method="GET" class="mx-auto my-4 lg:my-0 w-full max-w-2xl px-0 lg:px-6">
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="bi bi-search text-gray-400 group-focus-within:text-orange-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" placeholder="Search for products, brands and more..." class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-full bg-gray-50 text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all shadow-inner" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" />
                    <button type="submit" class="absolute inset-y-1 right-1 px-4 bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium rounded-full transition-colors shadow-sm">
                        Search
                    </button>
                </div>
            </form>

            <!-- Right Actions -->
            <ul class="navbar-nav ms-auto flex items-center gap-4 mt-3 lg:mt-0 flex-row justify-center lg:justify-end">
                <?php if ($isLoggedIn): ?>
                    <!-- Sell Button -->
                    <li class="nav-item hidden lg:block">
                        <a href="/items/add" class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-sm font-semibold rounded-full hover:shadow-lg hover:shadow-orange-500/30 hover:-translate-y-0.5 transition-all no-underline">
                            <i class="bi bi-plus-circle-fill"></i> Sell Item
                        </a>
                    </li>
                    
                    <!-- Notifications -->
                    <li class="nav-item hidden lg:block">
                        <a href="/requests" class="relative p-2 text-gray-500 hover:text-orange-500 transition-colors rounded-full hover:bg-orange-50">
                            <i class="bi bi-bell text-xl"></i>
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                        </a>
                    </li>

                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle flex items-center gap-2 p-1 pr-3 bg-gray-50 border border-gray-200 rounded-full hover:bg-white hover:border-gray-300 transition-all" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-sm">
                                <?= htmlspecialchars($userInitial) ?>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 hidden lg:block"><?= htmlspecialchars($userName) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-xl border-0 rounded-2xl mt-3 p-2 min-w-[240px]">
                            <li class="px-4 py-3 border-b border-gray-100 mb-2 bg-gray-50/50 rounded-t-xl">
                                <div class="font-bold text-sm text-gray-900"><?= htmlspecialchars($userName) ?></div>
                                <div class="text-xs text-gray-500 truncate"><?= htmlspecialchars($userEmail) ?></div>
                            </li>
                            
                            <?php if ($userRole === 'admin'): ?>
                                <li><a class="dropdown-item flex items-center gap-3 px-4 py-2 text-sm font-medium text-orange-600 hover:bg-orange-50 rounded-lg transition-colors" href="/admin/dashboard"><i class="bi bi-shield-check text-lg"></i>Admin Dashboard</a></li>
                                <li><hr class="dropdown-divider my-1 border-gray-100"></li>
                            <?php endif; ?>
                            
                            <li><a class="dropdown-item flex items-center gap-3 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-orange-500 rounded-lg transition-colors" href="/dashboard"><i class="bi bi-grid-1x2 text-lg text-gray-400"></i>Dashboard</a></li>
                            <li><a class="dropdown-item flex items-center gap-3 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-orange-500 rounded-lg transition-colors" href="/items"><i class="bi bi-box-seam text-lg text-gray-400"></i>My Listings</a></li>
                            <li><a class="dropdown-item flex items-center gap-3 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-orange-500 rounded-lg transition-colors" href="/requests"><i class="bi bi-chat-left-dots text-lg text-gray-400"></i>Requests</a></li>
                            <li><hr class="dropdown-divider my-1 border-gray-100"></li>
                            <li><a class="dropdown-item flex items-center gap-3 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-orange-500 rounded-lg transition-colors" href="/profile"><i class="bi bi-person text-lg text-gray-400"></i>Account Settings</a></li>
                            <li><a class="dropdown-item flex items-center gap-3 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors mt-1" href="/logout"><i class="bi bi-box-arrow-right text-lg"></i>Sign Out</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- Logged Out Links -->
                    <li class="nav-item">
                        <a class="nav-link px-4 py-2 text-sm font-semibold text-gray-600 hover:text-orange-500 transition-colors" href="/login">
                            Sign In
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold rounded-full transition-all shadow-md no-underline" href="/register">
                            Get Started
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Flash Messages Overlay -->
<?php if (!empty($_SESSION['flash'])): ?>
    <?php $flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
    <div id="toast-msg" class="fixed top-24 right-6 flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg z-50 transform transition-all duration-300 <?= $flash['type'] === 'success' ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-red-50 text-red-800 border border-red-200' ?>">
        <?php if ($flash['type'] === 'success'): ?>
            <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
        <?php else: ?>
            <i class="bi bi-exclamation-triangle-fill text-red-500 text-xl"></i>
        <?php endif; ?>
        <span class="text-sm font-medium"><?= htmlspecialchars($flash['msg']) ?></span>
        <button onclick="this.parentElement.remove()" class="ml-2 text-gray-400 hover:text-gray-600 focus:outline-none">✕</button>
    </div>
    <script>
        setTimeout(function() {
            var t = document.getElementById('toast-msg');
            if(t) {
                t.style.opacity = '0';
                t.style.transform = 'translateY(-20px)';
                setTimeout(() => t.remove(), 300);
            }
        }, 4000);
    </script>
<?php endif; ?>