<?php
$pageTitle = 'My Listings';
require __DIR__ . '/../includes/dashboard-header.php';
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <a href="/dashboard">Home</a>
    <span class="sep">/</span>
    <span class="current">My Listings</span>
</div>

<!-- Page Header -->
<div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;margin-bottom:16px;">
    <div>
        <h1 style="font-size:1.25rem;font-weight:700;color:var(--text-primary);">My Listings</h1>
        <p class="text-sm text-muted mt-1">Manage, edit, or remove your posted items</p>
    </div>
    <a href="/items/add" class="btn btn-primary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add New Item
    </a>
</div>

<!-- Alerts -->
<?php if (!empty($message)): ?>
<div class="alert alert-green mb-4">
    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <span><?= htmlspecialchars($message) ?></span>
</div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] === 'cannot_edit'): ?>
<div class="alert alert-yellow mb-4">
    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
    <span>This item cannot be edited because it has pending or approved requests.</span>
</div>
<?php endif; ?>

<!-- Items Grid -->
<?php if (empty($items)): ?>
<div class="card">
    <div class="empty-state">
        <div class="icon">📦</div>
        <div class="title">No listings yet</div>
        <div class="desc">Start selling by adding your first item</div>
        <a href="/items/add" class="btn btn-primary mt-4">+ Add First Listing</a>
    </div>
</div>
<?php else: ?>
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:14px;">
    <?php foreach ($items as $item):
        $statusBadge = [
            'active'   => 'badge-green',
            'sold'     => 'badge-gray',
            'reserved' => 'badge-yellow',
        ][strtolower($item['status'] ?? '')] ?? 'badge-gray';
    ?>
    <article class="item-card">
        <!-- Image -->
        <div class="item-img" style="height:160px;">
            <?php if (!empty($item['image'])): ?>
                <img src="/uploads/items/<?= htmlspecialchars($item['image']) ?>"
                     alt="<?= htmlspecialchars($item['title']) ?>" loading="lazy" />
            <?php else: ?>
                <div class="no-img">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>No Image</span>
                </div>
            <?php endif; ?>
            <span class="item-status-badge badge <?= $statusBadge ?>"><?= ucfirst($item['status'] ?? 'active') ?></span>
        </div>

        <!-- Info -->
        <div class="item-body">
            <div class="item-title"><?= htmlspecialchars($item['title']) ?></div>
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <div class="item-price">₹<?= number_format((float)$item['price'], 0) ?></div>
                <span class="badge badge-gray" style="font-size:.625rem;"><?= ucfirst($item['mode'] ?? '') ?></span>
            </div>
            <div class="item-city">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <?= htmlspecialchars($item['city']) ?>
            </div>

            <!-- Action buttons -->
            <div style="margin-top:auto;padding-top:8px;display:grid;grid-template-columns:1fr 1fr 1fr;gap:6px;">
                <a href="/items/view/<?= $item['id'] ?>" class="btn btn-primary btn-sm" style="justify-content:center;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    View
                </a>
                <a href="/items/edit/<?= $item['id'] ?>" class="btn btn-secondary btn-sm" style="justify-content:center;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                </a>
                <form action="/items/delete/<?= $item['id'] ?>" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this item?');">
                    <button type="submit" class="btn btn-danger btn-sm btn-block" style="justify-content:center;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Del
                    </button>
                </form>
            </div>
        </div>
    </article>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php require __DIR__ . '/../includes/dashboard-footer.php'; ?>
