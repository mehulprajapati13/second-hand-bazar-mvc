<?php
$pageTitle = 'Requests';
require __DIR__ . '/../includes/dashboard-header.php';

// Badge class helper
function reqBadgeClass(string $st): string {
    return [
        'pending'   => 'badge-yellow',
        'approved'  => 'badge-green',
        'rejected'  => 'badge-red',
        'completed' => 'badge-purple',
        'cancelled' => 'badge-gray',
    ][$st] ?? 'badge-gray';
}
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <a href="/dashboard">Home</a>
    <span class="sep">/</span>
    <span class="current">Requests</span>
</div>

<!-- Page Header -->
<div class="flex items-center justify-between mb-4 flex-wrap gap-3">
    <div>
        <h1 style="font-size:1.25rem;font-weight:700;color:var(--text-primary);">Requests</h1>
        <p class="text-sm text-muted mt-1">Manage incoming and outgoing purchase / rental requests</p>
    </div>
</div>

<!-- Flash Message -->
<?php if (isset($_GET['msg'])): ?>
    <?php $msgMap = [
        'approved'  => ['text' => 'Request approved. Item is now reserved.', 'cls' => 'alert-green'],
        'rejected'  => ['text' => 'Request rejected.',                        'cls' => 'alert-red'],
        'sold'      => ['text' => 'Item marked as sold.',                     'cls' => 'alert-blue'],
        'returned'  => ['text' => 'Item returned and set back to active.',    'cls' => 'alert-blue'],
        'cancelled' => ['text' => 'Request cancelled.',                       'cls' => 'alert-yellow'],
    ]; $msg = $msgMap[$_GET['msg']] ?? null; ?>
    <?php if ($msg): ?>
    <div class="alert <?= $msg['cls'] ?> mb-4">
        <span><?= $msg['text'] ?></span>
    </div>
    <?php endif; ?>
<?php endif; ?>

<!-- Tabs -->
<?php $pendingCount = count(array_filter($incomingRequests, fn($r) => $r['status'] === 'pending')); ?>
<div class="tabs mb-4">
    <a href="/requests?tab=received" class="tab-item <?= ($tab === 'received') ? 'active' : '' ?>">
        Received
        <?php if ($pendingCount > 0): ?><span class="tab-badge"><?= $pendingCount ?></span><?php endif; ?>
    </a>
    <a href="/requests?tab=sent" class="tab-item <?= ($tab === 'sent') ? 'active' : '' ?>">Sent</a>
</div>

<!-- RECEIVED TAB -->
<?php if ($tab === 'received'): ?>
    <?php if (empty($incomingRequests)): ?>
    <div class="card">
        <div class="empty-state">
            <div class="icon">📭</div>
            <div class="title">No incoming requests yet</div>
            <div class="desc">When buyers request your items, they'll appear here</div>
        </div>
    </div>
    <?php else: ?>
    <div class="space-y-4">
        <?php foreach ($incomingRequests as $req):
            $st = strtolower($req['status'] ?? 'pending');
        ?>
        <div class="request-card">
            <div class="request-thumb">
                <?php if (!empty($req['item_image'])): ?>
                    <img src="/uploads/items/<?= htmlspecialchars($req['item_image']) ?>" alt="" loading="lazy" />
                <?php else: ?>
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--text-muted);">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01"/></svg>
                    </div>
                <?php endif; ?>
            </div>
            <div class="request-info">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <div>
                        <div class="request-title"><?= htmlspecialchars($req['item_title']) ?></div>
                        <div class="request-meta mt-1">
                            Requested by <strong><?= htmlspecialchars($req['requester_name'] ?? '—') ?></strong>
                            · <?= date('d M Y', strtotime($req['created_at'])) ?>
                        </div>
                    </div>
                    <span class="badge <?= reqBadgeClass($st) ?>"><?= ucfirst($st) ?></span>
                </div>

                <div class="request-actions">
                    <?php if ($st === 'pending'): ?>
                        <form action="/requests/approve/<?= $req['id'] ?>" method="POST" style="display:inline;">
                            <button type="submit" class="btn btn-sm" style="background:var(--green-bg);color:var(--green-text);border:1px solid var(--green-border);">✓ Approve</button>
                        </form>
                        <form action="/requests/reject/<?= $req['id'] ?>" method="POST" style="display:inline;">
                            <button type="submit" class="btn btn-sm" style="background:var(--red-bg);color:var(--red-text);border:1px solid var(--red-border);">✗ Reject</button>
                        </form>
                        <a href="/items/view/<?= $req['item_id'] ?>" class="btn btn-secondary btn-sm">View Item</a>

                    <?php elseif ($st === 'approved'): ?>
                        <?php if (($req['item_mode'] ?? 'sell') === 'sell'): ?>
                        <form action="/requests/sold/<?= $req['id'] ?>" method="POST" onsubmit="return confirm('Mark this item as sold after handover?')" style="display:inline;">
                            <button type="submit" class="btn btn-sm" style="background:var(--purple-bg);color:var(--purple-text);border:1px solid var(--purple-border);">Mark as Sold</button>
                        </form>
                        <?php else: ?>
                        <form action="/requests/returned/<?= $req['id'] ?>" method="POST" onsubmit="return confirm('Mark item as returned?')" style="display:inline;">
                            <button type="submit" class="btn btn-sm" style="background:var(--blue-bg);color:var(--blue-text);border:1px solid var(--blue-border);">Mark as Returned</button>
                        </form>
                        <?php endif; ?>
                        <span class="alert alert-green" style="padding:6px 12px;font-size:.75rem;">Approved — arrange handover with buyer</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
<?php endif; ?>

<!-- SENT TAB -->
<?php if ($tab === 'sent'): ?>
    <?php if (empty($outgoingRequests)): ?>
    <div class="card">
        <div class="empty-state">
            <div class="icon">📤</div>
            <div class="title">No outgoing requests yet</div>
            <div class="desc">Browse items and send a request to get started</div>
            <a href="/browse" class="btn btn-primary mt-4">Browse Items →</a>
        </div>
    </div>
    <?php else: ?>
    <div class="space-y-4">
        <?php foreach ($outgoingRequests as $req):
            $st = strtolower($req['status'] ?? 'pending');
        ?>
        <div class="request-card">
            <div class="request-thumb">
                <?php if (!empty($req['item_image'])): ?>
                    <img src="/uploads/items/<?= htmlspecialchars($req['item_image']) ?>" alt="" loading="lazy" />
                <?php else: ?>
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--text-muted);">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01"/></svg>
                    </div>
                <?php endif; ?>
            </div>
            <div class="request-info">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <div>
                        <div class="request-title"><?= htmlspecialchars($req['item_title']) ?></div>
                        <div class="request-meta mt-1">
                            Seller: <strong><?= htmlspecialchars($req['owner_name'] ?? '—') ?></strong>
                            · <?= date('d M Y', strtotime($req['created_at'])) ?>
                        </div>
                    </div>
                    <span class="badge <?= reqBadgeClass($st) ?>"><?= ucfirst($st) ?></span>
                </div>

                <?php if ($st === 'approved'): ?>
                <div class="alert alert-green mt-3" style="font-size:.75rem;">✓ Approved! Contact the seller to arrange handover.</div>
                <?php endif; ?>

                <?php if ($st === 'pending'): ?>
                <div class="request-actions">
                    <form action="/requests/cancel/<?= $req['id'] ?>" method="POST" onsubmit="return confirm('Cancel this request?')" style="display:inline;">
                        <button type="submit" class="btn btn-secondary btn-sm" style="color:var(--red-text);">Cancel Request</button>
                    </form>
                    <a href="/items/view/<?= $req['item_id'] ?>" class="btn btn-ghost btn-sm text-brand">View Item →</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
<?php endif; ?>

<?php require __DIR__ . '/../includes/dashboard-footer.php'; ?>
