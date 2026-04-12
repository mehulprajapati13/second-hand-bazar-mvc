<?php
$pageTitle = 'Requests';
require __DIR__ . '/../includes/dashboard-header.php';
?>

<div class="breadcrumb">
    <a href="/dashboard">Home</a>
    <span class="sep">/</span>
    <span class="current">Requests</span>
</div>

<div style="margin-bottom:16px;">
    <h1 style="font-size:1.25rem;font-weight:700;color:var(--text-primary);">Requests</h1>
    <p class="text-sm text-muted mt-1">Manage your incoming and outgoing buy/rent requests</p>
</div>

<!-- Tabs -->
<div style="display:flex;gap:0;border-bottom:2px solid #e2e8f0;margin-bottom:20px;">
    <a href="/requests?tab=received"
        style="padding:10px 20px;font-size:0.875rem;font-weight:600;text-decoration:none;
              border-bottom:<?= $tab === 'received' ? '2px solid #f97316' : '2px solid transparent' ?>;
              color:<?= $tab === 'received' ? '#f97316' : '#64748b' ?>;margin-bottom:-2px;">
        Received
        <?php $pendingCount = count(array_filter($received, fn($r) => $r['status'] === 'pending')); ?>
        <?php if ($pendingCount > 0): ?>
            <span style="background:#ef4444;color:#fff;font-size:10px;font-weight:700;
                     padding:2px 7px;border-radius:20px;margin-left:6px;">
                <?= $pendingCount ?>
            </span>
        <?php endif; ?>
    </a>
    <a href="/requests?tab=sent"
        style="padding:10px 20px;font-size:0.875rem;font-weight:600;text-decoration:none;
              border-bottom:<?= $tab === 'sent' ? '2px solid #f97316' : '2px solid transparent' ?>;
              color:<?= $tab === 'sent' ? '#f97316' : '#64748b' ?>;margin-bottom:-2px;">
        Sent
    </a>
</div>

<?php
// Status badge helper
function statusBadge(string $status): array
{
    return match ($status) {
        'pending'   => ['bg' => '#fef3c7', 'color' => '#92400e', 'text' => 'Pending'],
        'approved'  => ['bg' => '#d1fae5', 'color' => '#065f46', 'text' => 'Approved'],
        'rejected'  => ['bg' => '#fee2e2', 'color' => '#991b1b', 'text' => 'Rejected'],
        'completed' => ['bg' => '#dbeafe', 'color' => '#1e40af', 'text' => 'Completed'],
        'cancelled' => ['bg' => '#f1f5f9', 'color' => '#475569', 'text' => 'Cancelled'],
        default     => ['bg' => '#f1f5f9', 'color' => '#475569', 'text' => ucfirst($status)],
    };
}
?>

<!-- ═══════════════ RECEIVED TAB ═══════════════ -->
<?php if ($tab === 'received'): ?>

    <?php if (empty($received)): ?>
        <div class="card">
            <div class="empty-state">
                <div class="icon">📭</div>
                <div class="title">No requests received yet</div>
                <div class="desc">When buyers request your items, they appear here</div>
            </div>
        </div>
    <?php else: ?>
        <div style="display:flex;flex-direction:column;gap:12px;">
            <?php foreach ($received as $req):
                $badge = statusBadge($req['status']);
            ?>
                <div class="card" style="padding:16px;">
                    <div style="display:flex;align-items:flex-start;gap:14px;">

                        <!-- Item image -->
                        <div style="width:64px;height:56px;border-radius:8px;overflow:hidden;background:#f1f5f9;flex-shrink:0;">
                            <?php if (!empty($req['item_image'])): ?>
                                <img src="/uploads/items/<?= htmlspecialchars($req['item_image']) ?>"
                                    style="width:100%;height:100%;object-fit:cover;">
                            <?php else: ?>
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#94a3b8;">
                                    <i class="bi bi-image"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div style="flex:1;min-width:0;">
                            <!-- Header row -->
                            <div style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                                <div>
                                    <div style="font-weight:600;font-size:0.9rem;">
                                        <?= htmlspecialchars($req['item_title']) ?>
                                        <span style="font-size:.75rem;font-weight:400;color:#64748b;margin-left:6px;">
                                            (<?= ucfirst($req['item_mode']) ?>)
                                        </span>
                                    </div>
                                    <div style="font-size:0.8rem;color:#64748b;margin-top:2px;">
                                        From: <strong><?= htmlspecialchars($req['requester_name']) ?></strong>
                                        · <?= date('d M Y', strtotime($req['created_at'])) ?>
                                    </div>
                                </div>
                                <span style="background:<?= $badge['bg'] ?>;color:<?= $badge['color'] ?>;
                                     font-size:.75rem;font-weight:700;padding:3px 10px;border-radius:20px;white-space:nowrap;">
                                    <?= $badge['text'] ?>
                                </span>
                            </div>

                            <!-- APPROVED: Show buyer contact info so seller can arrange handover -->
                            <?php if ($req['status'] === 'approved'): ?>
                                <div style="margin-top:12px;padding:12px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;">
                                    <div style="font-size:.8rem;font-weight:700;color:#15803d;margin-bottom:8px;">
                                        ✓ Approved — Contact buyer to arrange handover
                                    </div>
                                    <div style="display:flex;flex-wrap:wrap;gap:12px;">
                                        <?php if (!empty($req['requester_phone'])): ?>
                                            <a href="tel:<?= htmlspecialchars($req['requester_phone']) ?>"
                                                style="display:inline-flex;align-items:center;gap:6px;font-size:.8125rem;font-weight:600;color:#15803d;text-decoration:none;background:#dcfce7;padding:6px 12px;border-radius:6px;border:1px solid #bbf7d0;">
                                                <i class="bi bi-telephone-fill"></i>
                                                <?= htmlspecialchars($req['requester_phone']) ?>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($req['requester_email'])): ?>
                                            <a href="mailto:<?= htmlspecialchars($req['requester_email']) ?>"
                                                style="display:inline-flex;align-items:center;gap:6px;font-size:.8125rem;font-weight:600;color:#1d4ed8;text-decoration:none;background:#eff6ff;padding:6px 12px;border-radius:6px;border:1px solid #bfdbfe;">
                                                <i class="bi bi-envelope-fill"></i>
                                                <?= htmlspecialchars($req['requester_email']) ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Action buttons -->
                            <?php if ($req['status'] === 'pending'): ?>
                                <div style="display:flex;gap:8px;margin-top:10px;flex-wrap:wrap;">
                                    <form action="/requests/approve/<?= $req['id'] ?>" method="POST">
                                        <button type="submit"
                                            style="background:#16a34a;color:#fff;border:none;padding:6px 16px;border-radius:6px;font-weight:600;font-size:.875rem;cursor:pointer;">
                                            ✓ Approve
                                        </button>
                                    </form>
                                    <form action="/requests/reject/<?= $req['id'] ?>" method="POST">
                                        <button type="submit"
                                            style="background:#fee2e2;color:#991b1b;border:1px solid #fca5a5;padding:6px 16px;border-radius:6px;font-weight:600;font-size:.875rem;cursor:pointer;">
                                            ✗ Reject
                                        </button>
                                    </form>
                                </div>

                            <?php elseif ($req['status'] === 'approved'): ?>
                                <div style="margin-top:10px;">
                                    <?php if ($req['item_mode'] === 'sell'): ?>
                                        <form action="/requests/sold/<?= $req['id'] ?>" method="POST"
                                            onsubmit="return confirm('Mark as sold after physical handover?')">
                                            <button type="submit"
                                                style="background:#1d4ed8;color:#fff;border:none;padding:6px 16px;border-radius:6px;font-weight:600;font-size:.875rem;cursor:pointer;">
                                                Mark as Sold
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form action="/requests/returned/<?= $req['id'] ?>" method="POST"
                                            onsubmit="return confirm('Mark item as returned?')">
                                            <button type="submit"
                                                style="background:#7c3aed;color:#fff;border:none;padding:6px 16px;border-radius:6px;font-weight:600;font-size:.875rem;cursor:pointer;">
                                                Mark as Returned
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

<?php endif; ?>

<!-- ═══════════════ SENT TAB ═══════════════ -->
<?php if ($tab === 'sent'): ?>

    <?php if (empty($sent)): ?>
        <div class="card">
            <div class="empty-state">
                <div class="icon">📤</div>
                <div class="title">No requests sent yet</div>
                <div class="desc">Browse items and send a request to get started</div>
                <a href="/browse" class="btn btn-primary mt-4">Browse Items</a>
            </div>
        </div>
    <?php else: ?>
        <div style="display:flex;flex-direction:column;gap:12px;">
            <?php foreach ($sent as $req):
                $badge = statusBadge($req['status']);
            ?>
                <div class="card" style="padding:16px;">
                    <div style="display:flex;align-items:flex-start;gap:14px;">

                        <!-- Item image -->
                        <div style="width:64px;height:56px;border-radius:8px;overflow:hidden;background:#f1f5f9;flex-shrink:0;">
                            <?php if (!empty($req['item_image'])): ?>
                                <img src="/uploads/items/<?= htmlspecialchars($req['item_image']) ?>"
                                    style="width:100%;height:100%;object-fit:cover;">
                            <?php else: ?>
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#94a3b8;">
                                    <i class="bi bi-image"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div style="flex:1;min-width:0;">
                            <!-- Header row -->
                            <div style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                                <div>
                                    <div style="font-weight:600;font-size:0.9rem;">
                                        <?= htmlspecialchars($req['item_title']) ?>
                                        <span style="font-size:.75rem;font-weight:400;color:#64748b;margin-left:6px;">
                                            ₹<?= number_format((float)($req['item_price'] ?? 0), 0) ?>
                                        </span>
                                    </div>
                                    <div style="font-size:0.8rem;color:#64748b;margin-top:2px;">
                                        Seller: <strong><?= htmlspecialchars($req['owner_name']) ?></strong>
                                        · <?= date('d M Y', strtotime($req['created_at'])) ?>
                                    </div>
                                </div>
                                <span style="background:<?= $badge['bg'] ?>;color:<?= $badge['color'] ?>;
                                     font-size:.75rem;font-weight:700;padding:3px 10px;border-radius:20px;white-space:nowrap;">
                                    <?= $badge['text'] ?>
                                </span>
                            </div>

                            <!-- APPROVED: Show seller contact info so buyer can arrange handover -->
                            <?php if ($req['status'] === 'approved'): ?>
                                <div style="margin-top:12px;padding:12px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;">
                                    <div style="font-size:.8rem;font-weight:700;color:#15803d;margin-bottom:8px;">
                                        ✓ Request approved! Contact the seller to arrange handover
                                    </div>
                                    <div style="display:flex;flex-wrap:wrap;gap:12px;">
                                        <?php if (!empty($req['owner_phone'])): ?>
                                            <a href="tel:<?= htmlspecialchars($req['owner_phone']) ?>"
                                                style="display:inline-flex;align-items:center;gap:6px;font-size:.8125rem;font-weight:600;color:#15803d;text-decoration:none;background:#dcfce7;padding:6px 12px;border-radius:6px;border:1px solid #bbf7d0;">
                                                <i class="bi bi-telephone-fill"></i>
                                                <?= htmlspecialchars($req['owner_phone']) ?>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($req['owner_email'])): ?>
                                            <a href="mailto:<?= htmlspecialchars($req['owner_email']) ?>"
                                                style="display:inline-flex;align-items:center;gap:6px;font-size:.8125rem;font-weight:600;color:#1d4ed8;text-decoration:none;background:#eff6ff;padding:6px 12px;border-radius:6px;border:1px solid #bfdbfe;">
                                                <i class="bi bi-envelope-fill"></i>
                                                <?= htmlspecialchars($req['owner_email']) ?>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($req['owner_city'])): ?>
                                            <span style="display:inline-flex;align-items:center;gap:6px;font-size:.8125rem;color:#64748b;padding:6px 12px;">
                                                <i class="bi bi-geo-alt-fill"></i>
                                                <?= htmlspecialchars($req['owner_city']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($req['status'] === 'rejected'): ?>
                                <div style="margin-top:8px;padding:8px 12px;background:#fee2e2;border-radius:8px;font-size:.8rem;color:#991b1b;">
                                    Request was rejected. You can browse other similar items.
                                    <a href="/browse" style="font-weight:600;color:#991b1b;margin-left:6px;">Browse →</a>
                                </div>
                            <?php endif; ?>

                            <!-- Cancel button for pending requests -->
                            <?php if ($req['status'] === 'pending'): ?>
                                <div style="margin-top:10px;">
                                    <form action="/requests/cancel/<?= $req['id'] ?>" method="POST"
                                        onsubmit="return confirm('Cancel this request?')">
                                        <button type="submit"
                                            style="background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;padding:6px 16px;border-radius:6px;font-weight:600;font-size:.875rem;cursor:pointer;">
                                            Cancel Request
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

<?php endif; ?>

<?php require __DIR__ . '/../includes/dashboard-footer.php'; ?>