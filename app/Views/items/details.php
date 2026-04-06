<?php
$pageTitle = $item['title'] ?? 'Item Details';
require __DIR__ . '/../includes/dashboard-header.php';

$itemId      = (int)($item['id']          ?? 0);
$title       = (string)($item['title']    ?? 'Untitled item');
$image       = $item['image']             ?? null;
$status      = strtolower((string)($item['status']   ?? 'active'));
$mode        = strtolower((string)($item['mode']     ?? 'sell'));
$price       = (float)($item['price']     ?? 0);
$city        = (string)($item['city']     ?? 'Unknown');
$sellerName  = (string)($item['seller_name'] ?? 'Seller');
$description = (string)($item['description'] ?? 'No description provided.');
$listedOn    = !empty($item['created_at']) ? date('d M Y', strtotime($item['created_at'])) : 'N/A';

$statusBadge = [
    'active'   => 'badge-green',
    'sold'     => 'badge-gray',
    'reserved' => 'badge-yellow',
    'returned' => 'badge-blue',
][$status] ?? 'badge-gray';
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <a href="/dashboard">Home</a>
    <span class="sep">/</span>
    <a href="/browse">Browse</a>
    <span class="sep">/</span>
    <span class="current truncate" style="max-width:150px;"><?= htmlspecialchars($title) ?></span>
</div>

<!-- Detail Card -->
<div class="card mb-4">
    <div style="display:grid;grid-template-columns:1fr 1fr;" class="detail-layout">
        <!-- Image -->
        <div style="background:var(--bg-muted);min-height:320px;display:flex;align-items:center;justify-content:center;overflow:hidden;">
            <?php if (!empty($image)): ?>
                <img src="/uploads/items/<?= htmlspecialchars((string)$image) ?>"
                     alt="<?= htmlspecialchars($title) ?>"
                     style="width:100%;height:100%;object-fit:cover;min-height:320px;" />
            <?php else: ?>
                <div style="display:flex;flex-direction:column;align-items:center;gap:10px;color:var(--text-muted);padding:48px;">
                    <svg width="56" height="56" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span style="font-size:.875rem;color:var(--text-muted);">No image available</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Info Panel -->
        <div style="padding:28px;display:flex;flex-direction:column;gap:18px;">
            <!-- Badges -->
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <span class="badge <?= $statusBadge ?>"><?= ucfirst($status) ?></span>
                <span class="badge <?= $mode === 'rent' ? 'badge-blue' : 'badge-green' ?>">
                    For <?= ucfirst($mode) ?>
                </span>
            </div>

            <!-- Title & Price -->
            <div>
                <h1 style="font-size:1.375rem;font-weight:700;color:var(--text-primary);line-height:1.25;">
                    <?= htmlspecialchars($title) ?>
                </h1>
                <div style="font-size:1.75rem;font-weight:800;color:var(--text-primary);margin-top:10px;">
                    ₹<?= number_format($price, 0) ?>
                    <?php if ($mode === 'rent'): ?>
                        <span style="font-size:.875rem;font-weight:400;color:var(--text-muted);">/ day</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Details grid -->
            <div class="detail-grid">
                <div class="detail-cell">
                    <div class="detail-cell-label">Location</div>
                    <div class="detail-cell-value"><?= htmlspecialchars($city) ?></div>
                </div>
                <div class="detail-cell">
                    <div class="detail-cell-label">Seller</div>
                    <div class="detail-cell-value"><?= htmlspecialchars($sellerName) ?></div>
                </div>
                <div class="detail-cell full">
                    <div class="detail-cell-label">Listed on</div>
                    <div class="detail-cell-value"><?= htmlspecialchars($listedOn) ?></div>
                </div>
            </div>

            <!-- Description -->
            <div style="background:var(--bg-subtle);border:1px solid var(--border);border-radius:var(--radius-md);padding:14px;">
                <div style="font-size:.6875rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--text-muted);margin-bottom:6px;">Description</div>
                <p style="font-size:.875rem;color:var(--text-secondary);line-height:1.6;white-space:pre-line;">
                    <?= htmlspecialchars($description) ?>
                </p>
            </div>

            <!-- Action Area -->
            <div>
                <?php $isActive = $status === 'active'; ?>
                <?php if ($isOwner): ?>
                    <div class="alert alert-blue" style="flex-direction:column;gap:8px;text-align:center;">
                        <span>This is your listing.</span>
                        <a href="/items/edit/<?= $itemId ?>" class="btn btn-primary btn-sm" style="align-self:center;">Edit Item</a>
                    </div>

                <?php elseif (!$isActive): ?>
                    <div class="alert" style="background:var(--bg-muted);border-color:var(--border);color:var(--text-muted);justify-content:center;">
                        This item is no longer available.
                    </div>

                <?php else: ?>
                    <div class="alert alert-orange" style="flex-direction:column;text-align:center;gap:4px;">
                        <strong>Interested in this item?</strong>
                        <span style="font-size:.8125rem;">Contact the seller: <strong><?= htmlspecialchars($sellerName) ?></strong></span>
                    </div>
                <?php endif; ?>

                <a href="/browse" style="display:block;text-align:center;font-size:.8125rem;color:var(--text-muted);margin-top:12px;transition:color .12s;">
                    ← Back to Browse
                </a>
            </div>
        </div>
    </div>
</div>

<style>
@media (max-width: 768px) {
    .detail-layout { grid-template-columns: 1fr !important; }
}
</style>

<?php require __DIR__ . '/../includes/dashboard-footer.php'; ?>
