<?php
// Get current user info
$userName = trim($_SESSION['user']['name'] ?? 'User');
if ($userName === '') $userName = 'User';
$userEmail = $_SESSION['user']['email'] ?? '';
$userInitial = strtoupper(substr($userName, 0, 1));

// Current page for active menu
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>

<?php require __DIR__ . '/head.php'; ?>

<div class="dashboard-wrapper">
    <!-- Sidebar -->
    <aside class="sidebar bg-white border-end">
        <!-- Logo -->
        <div class="sidebar-header border-bottom">
            <a href="/" class="d-flex align-items-center text-decoration-none">
                <div class="logo-icon">
                    <i class="bi bi-cart3"></i>
                </div>
                <div class="ms-2">
                    <div class="logo-text text-dark">SecondHand<span class="text-brand">Bazaar</span></div>
                    <small class="text-muted">Marketplace</small>
                </div>
            </a>
        </div>

        <!-- User Info -->
        <div class="user-info border-bottom">
            <div class="d-flex align-items-center">
                <div class="user-avatar">
                    <?= htmlspecialchars($userInitial) ?>
                </div>
                <div class="ms-2 flex-grow-1" style="min-width: 0;">
                    <div class="fw-semibold small text-truncate"><?= htmlspecialchars($userName) ?></div>
                    <small class="text-muted text-truncate d-block"><?= htmlspecialchars($userEmail) ?></small>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="sidebar-nav">
            <small class="text-muted text-uppercase px-3 d-block mb-2">Menu</small>

            <a href="/dashboard" class="nav-link <?= str_starts_with($currentPath, '/dashboard') ? 'active' : '' ?>">
                <i class="bi bi-house-door"></i>
                <span>Dashboard</span>
            </a>

            <a href="/browse" class="nav-link <?= str_starts_with($currentPath, '/browse') ? 'active' : '' ?>">
                <i class="bi bi-grid"></i>
                <span>Browse Items</span>
            </a>

            <a href="/items" class="nav-link <?= str_starts_with($currentPath, '/items') ? 'active' : '' ?>">
                <i class="bi bi-list-ul"></i>
                <span>My Listings</span>
            </a>

            <a href="/requests" class="nav-link <?= str_starts_with($currentPath, '/requests') ? 'active' : '' ?>">
                <i class="bi bi-chat-dots"></i>
                <span>Requests</span>
            </a>

            <a href="/profile" class="nav-link <?= str_starts_with($currentPath, '/profile') ? 'active' : '' ?>">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </nav>

        <!-- Bottom Actions -->
        <div class="sidebar-footer border-top">
            <a href="/items/add" class="btn btn-brand w-100 mb-2">
                <i class="bi bi-plus-lg me-1"></i> New Listing
            </a>
            <a href="/logout" class="btn btn-outline-danger w-100">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Top Navigation Bar -->
        <nav class="navbar navbar-light bg-white border-bottom top-navbar">
            <div class="container-fluid">
                <!-- Mobile Menu Toggle -->
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <span class="navbar-brand mb-0 d-lg-none">
                    SecondHand<span class="text-brand">Bazaar</span>
                </span>

                <!-- Search Bar (Desktop) -->
                <form action="/browse" method="GET" class="d-none d-md-flex flex-grow-1 mx-3" style="max-width: 400px;">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search listings...">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Right Actions -->
                <div class="d-flex align-items-center gap-2">
                    <a href="/items/add" class="btn btn-brand d-none d-sm-inline-flex">
                        <i class="bi bi-plus-lg me-1"></i> List Item
                    </a>

                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-link text-decoration-none dropdown-toggle p-0" type="button" data-bs-toggle="dropdown">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar small">
                                    <?= htmlspecialchars($userInitial) ?>
                                </div>
                                <span class="ms-2 d-none d-sm-inline small"><?= htmlspecialchars($userName) ?></span>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <h6 class="dropdown-header text-truncate"><?= htmlspecialchars($userName) ?></h6>
                            </li>
                            <li><small class="dropdown-header text-muted text-truncate"><?= htmlspecialchars($userEmail) ?></small></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i>Edit Profile</a></li>
                            <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Page Content -->
        <div class="page-content">

            <?php if (!empty($_SESSION['flash'])): ?>
                <?php $flash = $_SESSION['flash'];
                unset($_SESSION['flash']); ?>
                <div id="toast-msg" style="
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
            background: <?= $flash['type'] === 'success' ? '#22c55e' : '#ef4444' ?>;
            color: #fff;
            min-width: 240px;
            max-width: 380px;
        ">
                    <?php if ($flash['type'] === 'success'): ?>
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    <?php else: ?>
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    <?php endif; ?>
                    <span><?= htmlspecialchars($flash['msg']) ?></span>
                    <button onclick="this.parentElement.remove()" style="
                margin-left: auto;
                background: none;
                border: none;
                color: #fff;
                cursor: pointer;
                padding: 0;
                line-height: 1;
                opacity: 0.8;
                font-size: 1rem;
            ">✕</button>
                </div>
                <script>
                    setTimeout(function() {
                        var t = document.getElementById('toast-msg');
                        if (t) {
                            t.style.transition = 'opacity 0.5s ease';
                            t.style.opacity = '0';
                            setTimeout(function() {
                                t.remove();
                            }, 500);
                        }
                    }, 3500);
                </script>
            <?php endif; ?>