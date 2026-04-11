<?php
$adminName   = $_SESSION['user']['name'] ?? 'Admin';
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel — SecondHand Bazaar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            background: #f1f5f9;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
        }

        .admin-sidebar {
            width: 220px;
            min-height: 100vh;
            background: #1e293b;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
        }

        .admin-sidebar .brand {
            padding: 18px 20px;
            font-size: 1rem;
            font-weight: 700;
            color: #f97316;
            border-bottom: 1px solid #334155;
        }

        .admin-sidebar .brand span {
            color: #fff;
        }

        .admin-sidebar nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 20px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all .15s;
        }

        .admin-sidebar nav a:hover {
            color: #fff;
            background: #334155;
        }

        .admin-sidebar nav a.active {
            color: #fff;
            background: #f97316;
        }

        .admin-sidebar .sidebar-footer {
            margin-top: auto;
            padding: 16px 20px;
            border-top: 1px solid #334155;
        }

        .admin-main {
            margin-left: 220px;
            padding: 22px;
            min-height: 100vh;
        }

        .admin-topbar {
            background: #fff;
            border-radius: 10px;
            padding: 12px 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
        }

        .admin-table {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
        }

        .admin-table table {
            margin: 0;
        }

        .admin-table thead th {
            background: #f8fafc;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: .05em;
            border-bottom: 2px solid #e2e8f0;
        }

        .admin-table tbody td {
            font-size: 0.875rem;
            vertical-align: middle;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
            border: 1px solid #e2e8f0;
        }

        .stat-card .value {
            font-size: 2rem;
            font-weight: 800;
        }

        .stat-card .label {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
        }
    </style>
</head>

<body>

    <!-- Toast -->
    <?php if (!empty($_SESSION['flash'])): ?>
        <?php $flash = $_SESSION['flash'];
        unset($_SESSION['flash']); ?>
        <div id="toast-msg" style="position:fixed;top:20px;right:20px;z-index:9999;display:flex;align-items:center;gap:10px;padding:12px 18px;border-radius:10px;font-size:.875rem;font-weight:600;box-shadow:0 4px 16px rgba(0,0,0,.15);background:<?= $flash['type'] === 'success' ? '#22c55e' : '#ef4444' ?>;color:#fff;min-width:240px;">
            <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle' : 'x-circle' ?>"></i>
            <?= htmlspecialchars($flash['msg']) ?>
        </div>
        <script>
            setTimeout(function() {
                var t = document.getElementById('toast-msg');
                if (t) {
                    t.style.transition = 'opacity .5s';
                    t.style.opacity = '0';
                    setTimeout(function() {
                        t.remove()
                    }, 500)
                }
            }, 3000);
        </script>
    <?php endif; ?>

    <!-- Sidebar -->
    <div class="admin-sidebar">
        <div class="brand"><span>SHB</span> Admin</div>
        <nav style="flex:1;padding-top:6px;">
            <a href="/admin/dashboard" class="<?= str_starts_with($currentPath, '/admin/dashboard') ? 'active' : '' ?>">
                <i class="bi bi-people"></i> Users
            </a>
            <a href="/admin/items" class="<?= str_starts_with($currentPath, '/admin/items') ? 'active' : '' ?>">
                <i class="bi bi-box-seam"></i> Items
            </a>
        </nav>
        <div class="sidebar-footer">
            <div style="font-size:.75rem;color:#94a3b8;margin-bottom:8px;">
                Logged in as <strong style="color:#fff;"><?= htmlspecialchars($adminName) ?></strong>
            </div>
            <a href="/dashboard" class="btn btn-outline-secondary btn-sm w-100 mb-2">
                <i class="bi bi-arrow-left me-1"></i> Back to Site
            </a>
            <a href="/logout" class="btn btn-outline-danger btn-sm w-100">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="admin-main">
        <div class="admin-topbar">
            <div style="font-size:1rem;font-weight:700;color:#1e293b;">
                <i class="bi bi-shield-check text-warning me-1"></i> Admin Panel
            </div>
            <div style="font-size:.875rem;font-weight:600;color:#64748b;">
                <?= htmlspecialchars($adminName) ?>
            </div>
        </div>