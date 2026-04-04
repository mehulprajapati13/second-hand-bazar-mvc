<?php
$pageTitle = 'Browse Items';
require __DIR__ . '/../includes/dashboard-header.php';
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <a href="/dashboard">Home</a>
    <span class="sep">/</span>
    <span class="current">Browse Items</span>
</div>

<!-- Filter Card -->
<div class="card mb-4">
    <div class="card-body">
        <div style="margin-bottom:14px;">
            <h1 style="font-size:1.125rem;font-weight:700;color:var(--text-primary);">Browse Listings</h1>
            <p class="text-xs text-muted mt-1">Find quality second-hand products from verified local sellers</p>
        </div>

        <form method="GET" style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end;">
            <!-- Search -->
            <div style="flex:1;min-width:160px;">
                <label class="form-label" style="margin-bottom:5px;display:block;">Search</label>
                <div class="search-bar" style="max-width:none;border-radius:var(--radius-md);">
                    <input type="text" name="search"
                           value="<?= htmlspecialchars($filters['search'] ?? '') ?>"
                           placeholder="Phone, chair, books…" />
                    <button type="submit" aria-label="Search">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>
            </div>

            <!-- City -->
            <div style="min-width:130px;">
                <label class="form-label" style="margin-bottom:5px;display:block;">City</label>
                <input type="text" name="city"
                       value="<?= htmlspecialchars($filters['city'] ?? '') ?>"
                       placeholder="Any city"
                       class="form-control" style="width:100%;" />
            </div>

            <!-- Type -->
            <div style="min-width:120px;">
                <label class="form-label" style="margin-bottom:5px;display:block;">Type</label>
                <select name="mode" class="form-control" style="width:100%;">
                    <option value="">All Types</option>
                    <option value="sell" <?= ($filters['mode'] ?? '') === 'sell' ? 'selected' : '' ?>>For Sale</option>
                    <option value="rent" <?= ($filters['mode'] ?? '') === 'rent' ? 'selected' : '' ?>>For Rent</option>
                </select>
            </div>

            <!-- Actions -->
            <div style="display:flex;gap:8px;">
                <button type="submit" class="btn btn-primary">Apply</button>
                <a href="/browse" class="btn btn-secondary">Clear</a>
            </div>
        </form>
    </div>
</div>

<!-- Results -->
<?php if (empty($items)): ?>
<div class="card">
    <div class="empty-state">
        <div class="icon">🔍</div>
        <div class="title">No items found</div>
        <div class="desc">Try adjusting your filters or search keywords</div>
        <a href="/browse" class="btn btn-ghost mt-4 text-brand">Clear all filters →</a>
    </div>
</div>
<?php else: ?>
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
    <span class="text-sm text-muted"><?= count($items) ?> listing<?= count($items) !== 1 ? 's' : '' ?> found</span>
</div>
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px;">
    <?php foreach ($items as $listing): ?>
    <article class="item-card">
        <div class="item-img" style="height:160px;">
            <?php if (!empty($listing['image'])): ?>
                <img src="/uploads/items/<?= htmlspecialchars($listing['image']) ?>"
                     alt="<?= htmlspecialchars($listing['title']) ?>" loading="lazy" />
            <?php else: ?>
                <div class="no-img">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>No Image</span>
                </div>
            <?php endif; ?>
            <?php if (!empty($listing['mode'])): ?>
            <span class="item-mode-badge badge <?= $listing['mode'] === 'rent' ? 'badge-blue' : 'badge-green' ?>">
                <?= ucfirst($listing['mode']) ?>
            </span>
            <?php endif; ?>
        </div>
        <div class="item-body">
            <div class="item-title"><?= htmlspecialchars($listing['title']) ?></div>
            <div class="item-price">₹<?= number_format((float)$listing['price'], 0) ?></div>
            <div class="item-city">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <?= htmlspecialchars($listing['city']) ?>
            </div>
            <div class="item-actions">
                <a href="/items/view/<?= $listing['id'] ?>" class="btn btn-primary btn-sm btn-block">View Details</a>
            </div>
        </div>
    </article>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php require __DIR__ . '/../includes/dashboard-footer.php'; ?>
