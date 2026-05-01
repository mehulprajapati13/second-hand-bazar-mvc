<?php require __DIR__ . '/header.php'; ?>

<div class="admin-card">
    <div class="d-flex align-items-center justify-content-between p-4 border-bottom">
        <h5 style="font-weight:700;margin:0;color:var(--admin-text);">All Items</h5>
        <span class="admin-badge badge-brand"><?= count($items) ?> Items</span>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Item Details</th>
                    <th>Seller Info</th>
                    <th>Price</th>
                    <th>City & Mode</th>
                    <th>Date Listed</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($items)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            No items found.
                        </td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td style="max-width: 250px;">
                            <div style="font-weight:600;color:var(--admin-text);margin-bottom:4px;" class="text-truncate"><?= htmlspecialchars($item['title']) ?></div>
                            <div style="font-size:0.8rem;color:var(--admin-text-muted);" class="text-truncate">
                                <?= htmlspecialchars($item['description']) ?>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:500;color:var(--admin-text);"><?= htmlspecialchars($item['seller_name'] ?? '—') ?></div>
                            <div style="font-size:0.8rem;color:var(--admin-text-muted);"><?= htmlspecialchars($item['seller_email'] ?? '—') ?></div>
                        </td>
                        <td>
                            <div style="font-weight:700;color:var(--admin-text);">₹<?= number_format((float)($item['price'] ?? 0), 0) ?></div>
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <span class="d-flex align-items-center gap-1 text-muted" style="font-size:0.85rem;">
                                    <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($item['city'] ?? '—') ?>
                                </span>
                                <?php if (($item['mode'] ?? '') === 'sell'): ?>
                                    <span class="admin-badge badge-success" style="align-self:flex-start;">For Sale</span>
                                <?php elseif (($item['mode'] ?? '') === 'rent'): ?>
                                    <span class="admin-badge badge-primary" style="align-self:flex-start;">For Rent</span>
                                <?php else: ?>
                                    <span class="admin-badge badge-warning" style="align-self:flex-start;">Unknown</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td style="color:var(--admin-text-muted);font-size:0.85rem;">
                            <?= date('d M Y', strtotime($item['created_at'] ?? 'now')) ?>
                        </td>
                        <td>
                            <div class="d-flex justify-content-end">
                                <form action="/admin/items/delete/<?= $item['id'] ?>" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete <?= htmlspecialchars($item['title']) ?>? This action cannot be undone.')">
                                    <button type="submit" class="btn-icon danger" title="Delete Item">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>   
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require __DIR__ . '/footer.php'; ?>