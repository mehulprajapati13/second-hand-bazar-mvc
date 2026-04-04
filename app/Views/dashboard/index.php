<?php
$pageTitle = 'Dashboard';
require __DIR__ . '/../includes/dashboard-header.php';
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <a href="/dashboard">Home</a>
    <span class="sep">/</span>
    <span class="current">Dashboard</span>
</div>

<!-- Welcome Banner -->
<div class="welcome-banner mb-6">
    <div>
        <small>Welcome back 👋</small>
        <h1><?= htmlspecialchars($_SESSION['user']['name'] ?? 'User') ?></h1>
        <p>Manage your listings and track your marketplace activity.</p>
    </div>
    <div class="welcome-banner-actions">
        <a href="/items/add" class="btn" style="background:#fff;color:var(--brand-600);font-weight:700;box-shadow:var(--shadow-sm);">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Add Listing
        </a>
        <a href="/browse" class="btn" style="background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.3);color:#fff;">
            Browse
        </a>
    </div>
</div>

<!-- Stats Grid -->
<?php
$cards = [
    ['Total Items',       $summary['total_items']        ?? 0, 'var(--blue-bg)',   'var(--blue-text)',   '<path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>'],
    ['Active Items',      $summary['active_items']       ?? 0, 'var(--green-bg)',  'var(--green-text)',  '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
    ['Reserved',          $summary['reserved_items']     ?? 0, 'var(--yellow-bg)', 'var(--yellow-text)', '<path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>'],
    ['Sold',              $summary['sold_items']         ?? 0, 'var(--purple-bg)', 'var(--purple-text)', '<path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>'],
    ['Requests Received', $summary['requests_received']  ?? 0, 'var(--orange-bg)', 'var(--orange-text)', '<path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>'],
    ['Requests Sent',     $summary['requests_sent']      ?? 0, 'var(--cyan-bg)',   'var(--cyan-text)',   '<path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>'],
];
?>
<div class="grid-4 mb-6" style="grid-template-columns:repeat(auto-fill,minmax(140px,1fr));">
    <?php foreach ($cards as [$label, $value, $iconBg, $iconColor, $iconPath]): ?>
    <div class="stat-card">
        <div class="stat-icon" style="background:<?= $iconBg ?>;color:<?= $iconColor ?>;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><?= $iconPath ?></svg>
        </div>
        <div class="stat-value"><?= htmlspecialchars((string)$value) ?></div>
        <div class="stat-label"><?= htmlspecialchars($label) ?></div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Recent Listings -->
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-header-title">Recent Listings</div>
            <div class="card-header-sub">Your most recently posted items</div>
        </div>
        <a href="/browse" class="btn btn-ghost btn-sm text-brand">See all →</a>
    </div>

    <?php if (empty($recentItems)): ?>
    <div class="empty-state">
        <div class="icon">📦</div>
        <div class="title">No listings yet</div>
        <div class="desc">Add your first item to start selling</div>
        <a href="/items/add" class="btn btn-primary mt-4">+ Add First Listing</a>
    </div>
    <?php else: ?>
    <div class="card-body-sm" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;">
        <?php foreach (array_slice($recentItems, 0, 10) as $item): ?>
        <article class="item-card">
            <div class="item-img" style="height:140px;">
                <?php if (!empty($item['image'])): ?>
                    <img src="/uploads/items/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" loading="lazy" />
                <?php else: ?>
                    <div class="no-img">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>No Image</span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="item-body">
                <div class="item-title"><?= htmlspecialchars($item['title']) ?></div>
                <div class="item-price">₹<?= number_format((float)$item['price'], 0) ?></div>
                <div class="item-city">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <?= htmlspecialchars($item['city']) ?>
                </div>
                <div class="item-actions">
                    <a href="/items/view/<?= $item['id'] ?>" class="btn btn-primary btn-sm btn-block">View</a>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../includes/dashboard-footer.php'; ?>
