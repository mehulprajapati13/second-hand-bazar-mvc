<?php
$adminName   = $_SESSION['user']['name'] ?? 'Admin';
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard — SecondHand Bazaar</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet" />
    
    <style>
        :root {
            --admin-brand: #f59e0b; /* Amber */
            --admin-brand-light: #fef3c7; /* Amber 100 */
            --admin-bg: #f8fafc; /* Slate 50 */
            --admin-surface: #ffffff;
            --admin-text: #0f172a; /* Slate 900 */
            --admin-text-muted: #64748b; /* Slate 500 */
            --admin-border: #e2e8f0; /* Slate 200 */
            --admin-sidebar-bg: #0f172a; /* Slate 900 */
            --admin-sidebar-text: #94a3b8; /* Slate 400 */
            --admin-sidebar-hover: #1e293b; /* Slate 800 */
            --radius-md: 12px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -2px rgba(0,0,0,0.05);
        }

        body {
            background-color: var(--admin-bg);
            color: var(--admin-text);
            font-family: 'Inter', system-ui, sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        /* Layout */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 260px;
            background-color: var(--admin-sidebar-bg);
            color: var(--admin-sidebar-text);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
            box-shadow: 2px 0 8px rgba(0,0,0,0.1);
        }

        .sidebar-brand {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .sidebar-brand-text {
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: -0.02em;
        }

        .sidebar-nav {
            padding: 20px 16px;
            flex: 1;
        }

        .sidebar-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--admin-sidebar-text);
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            margin-bottom: 6px;
        }

        .sidebar-nav-item i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-nav-item:hover {
            color: #fff;
            background-color: var(--admin-sidebar-hover);
        }

        .sidebar-nav-item.active {
            color: var(--admin-brand);
            background-color: rgba(245, 158, 11, 0.1);
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        .admin-user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(255,255,255,0.03);
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.05);
            margin-bottom: 16px;
        }

        .admin-avatar {
            width: 36px;
            height: 36px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--admin-sidebar-bg);
            font-weight: 700;
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
        }

        .admin-header {
            height: 72px;
            background-color: var(--admin-surface);
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .admin-content {
            padding: 32px;
            flex: 1;
        }

        /* Cards & Components */
        .admin-card {
            background: var(--admin-surface);
            border-radius: var(--radius-md);
            border: 1px solid var(--admin-border);
            box-shadow: var(--shadow-sm);
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .stat-info .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--admin-text);
            line-height: 1.2;
        }

        .stat-info .stat-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--admin-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 4px;
        }

        /* Tables */
        .table-responsive {
            margin: 0;
        }
        
        .admin-table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .admin-table th {
            background-color: #f8fafc;
            color: var(--admin-text-muted);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 16px 24px;
            border-bottom: 1px solid var(--admin-border);
            white-space: nowrap;
        }

        .admin-table td {
            padding: 16px 24px;
            vertical-align: middle;
            border-bottom: 1px solid var(--admin-border);
            color: var(--admin-text);
            font-size: 0.9rem;
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        .admin-table tbody tr:hover td {
            background-color: #f8fafc;
        }

        /* Badges */
        .admin-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef9c3; color: #854d0e; }
        .badge-primary { background: #dbeafe; color: #1e40af; }
        .badge-brand { background: var(--admin-brand-light); color: var(--admin-brand); }

        /* Forms */
        .admin-form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--admin-text);
            margin-bottom: 8px;
        }

        .admin-form-control {
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .admin-form-control:focus {
            border-color: var(--admin-brand);
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
            outline: none;
        }

        /* Buttons */
        .btn-admin-primary {
            background: var(--admin-brand);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .btn-admin-primary:hover {
            background: #d97706;
            color: #fff;
        }

        .btn-admin-outline {
            background: transparent;
            color: var(--admin-text);
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .btn-admin-outline:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: 1px solid var(--admin-border);
            background: #fff;
            color: var(--admin-text-muted);
            transition: all 0.2s;
        }

        .btn-icon:hover {
            background: #f8fafc;
            color: var(--admin-text);
        }

        .btn-icon.danger { color: #dc2626; border-color: #fecaca; background: #fef2f2; }
        .btn-icon.danger:hover { background: #fee2e2; border-color: #fca5a5; }

        .btn-icon.primary { color: #2563eb; border-color: #bfdbfe; background: #eff6ff; }
        .btn-icon.primary:hover { background: #dbeafe; border-color: #93c5fd; }
    </style>
</head>
<body>

<!-- Toast -->
<?php if (!empty($_SESSION['flash'])): ?>
    <?php $flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
    <div id="toast-msg" style="position:fixed;top:24px;right:24px;z-index:9999;display:flex;align-items:center;gap:12px;padding:16px 20px;border-radius:12px;font-size:0.9rem;font-weight:600;box-shadow:0 10px 25px rgba(0,0,0,0.1);background:<?= $flash['type'] === 'success' ? '#10b981' : '#ef4444' ?>;color:#fff;min-width:300px;animation:slideIn 0.3s ease;">
        <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle-fill' : 'exclamation-circle-fill' ?>" style="font-size:1.2rem;"></i>
        <?= htmlspecialchars($flash['msg']) ?>
    </div>
    <style>@keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }</style>
    <script>
        setTimeout(function() {
            var t = document.getElementById('toast-msg');
            if (t) {
                t.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                t.style.opacity = '0';
                t.style.transform = 'translateX(20px)';
                setTimeout(() => t.remove(), 400);
            }
        }, 4000);
    </script>
<?php endif; ?>

<div class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="bi bi-shield-check"></i>
            </div>
            <div class="sidebar-brand-text">Admin Panel</div>
        </div>
        
        <nav class="sidebar-nav">
            <div style="font-size:0.7rem;font-weight:700;color:var(--admin-sidebar-text);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:12px;padding:0 16px;">Management</div>
            
            <a href="/admin/dashboard" class="sidebar-nav-item <?= str_starts_with($currentPath, '/admin/dashboard') ? 'active' : '' ?>">
                <i class="bi bi-people"></i> Users
            </a>
            <a href="/admin/items" class="sidebar-nav-item <?= str_starts_with($currentPath, '/admin/items') ? 'active' : '' ?>">
                <i class="bi bi-box-seam"></i> Items
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <div class="admin-user-profile">
                <div class="admin-avatar">
                    <?= strtoupper(substr($adminName, 0, 1)) ?>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="color:#fff;font-size:0.85rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= htmlspecialchars($adminName) ?></div>
                    <div style="color:var(--admin-sidebar-text);font-size:0.75rem;">Administrator</div>
                </div>
            </div>
            <a href="/dashboard" class="sidebar-nav-item" style="color:var(--admin-sidebar-text);margin-bottom:0;">
                <i class="bi bi-arrow-left"></i> Exit to Site
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="admin-main">
        <header class="admin-header">
            <div style="font-size:1.1rem;font-weight:700;color:var(--admin-text);">
                <?php 
                    if(str_starts_with($currentPath, '/admin/dashboard')) echo 'Users Management';
                    elseif(str_starts_with($currentPath, '/admin/items')) echo 'Items Management';
                    else echo 'Admin Dashboard';
                ?>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="/logout" class="btn-admin-outline" style="padding:8px 16px;">
                    Logout
                </a>
            </div>
        </header>
        
        <div class="admin-content">