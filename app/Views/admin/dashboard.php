<?php require __DIR__ . '/header.php'; ?>

<!-- Stats Row -->
<div class="stat-grid">
    <div class="admin-card stat-card">
        <div class="stat-icon" style="background:#eff6ff;color:#3b82f6;">
            <i class="bi bi-people-fill"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value"><?= $stats['total_users'] ?? 0 ?></div>
            <div class="stat-label">Total Users</div>
        </div>
    </div>
    
    <div class="admin-card stat-card">
        <div class="stat-icon" style="background:#f0fdf4;color:#22c55e;">
            <i class="bi bi-box-seam-fill"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value"><?= $stats['active_items'] ?? 0 ?></div>
            <div class="stat-label">Active Items</div>
        </div>
    </div>
    
    <div class="admin-card stat-card">
        <div class="stat-icon" style="background:#fef3c7;color:#f59e0b;">
            <i class="bi bi-grid-fill"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value"><?= $stats['total_items'] ?? 0 ?></div>
            <div class="stat-label">Total Items</div>
        </div>
    </div>
    
    <div class="admin-card stat-card">
        <div class="stat-icon" style="background:#f8fafc;color:#64748b;">
            <i class="bi bi-bag-check-fill"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value"><?= $stats['sold_items'] ?? 0 ?></div>
            <div class="stat-label">Sold Items</div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="admin-card">
    <div class="d-flex align-items-center justify-content-between p-4 border-bottom">
        <h5 style="font-weight:700;margin:0;color:var(--admin-text);">Registered Users</h5>
        <span class="admin-badge badge-brand"><?= count($users) ?> users</span>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Contact Info</th>
                    <th>City</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        No users found.
                    </td>
                </tr>
                <?php endif; ?>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:36px;height:36px;border-radius:50%;background:#e2e8f0;display:flex;align-items:center;justify-content:center;font-weight:700;color:#64748b;">
                                <?= strtoupper(substr($u['name'], 0, 1)) ?>
                            </div>
                            <div>
                                <div style="font-weight:600;color:var(--admin-text);"><?= htmlspecialchars($u['name']) ?></div>
                                <div style="font-size:0.75rem;color:var(--admin-text-muted);">ID: #<?= $u['id'] ?></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div><?= htmlspecialchars($u['email']) ?></div>
                        <div style="font-size:0.8rem;color:var(--admin-text-muted);"><?= htmlspecialchars($u['phone'] ?? 'No phone') ?></div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-1 text-muted">
                            <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($u['city'] ?? '—') ?>
                        </div>
                    </td>
                    <td>
                        <?php if ($u['is_verified']): ?>
                            <span class="admin-badge badge-success"><i class="bi bi-check-circle me-1"></i> Verified</span>
                        <?php else: ?>
                            <span class="admin-badge badge-warning"><i class="bi bi-clock me-1"></i> Pending</span>
                        <?php endif; ?>
                    </td>
                    <td style="color:var(--admin-text-muted);"><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                    <td>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="/admin/users/edit/<?= $u['id'] ?>" class="btn-icon primary" title="Edit User">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="/admin/users/delete/<?= $u['id'] ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete <?= htmlspecialchars($u['name']) ?>? This action cannot be undone.')">
                                <button type="submit" class="btn-icon danger" title="Delete User">
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