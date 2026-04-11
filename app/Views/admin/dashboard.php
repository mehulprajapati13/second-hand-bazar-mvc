<?php require __DIR__ . '/header.php'; ?>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="value text-primary"><?= $stats['total_users'] ?? 0 ?></div>
            <div class="label">Total Users</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="value text-success"><?= $stats['active_items'] ?? 0 ?></div>
            <div class="label">Active Items</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="value" style="color:#f97316;"><?= $stats['total_items'] ?? 0 ?></div>
            <div class="label">Total Items</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="value text-secondary"><?= $stats['sold_items'] ?? 0 ?></div>
            <div class="label">Sold Items</div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="d-flex align-items-center justify-content-between mb-3">
    <h5 style="font-weight:700;margin:0;">All Users</h5>
    <span class="badge bg-primary"><?= count($users) ?> users</span>
</div>

<div class="admin-table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>City</th>
                <th>Verified</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
            <tr><td colspan="8" class="text-center py-4 text-muted">No users found.</td></tr>
            <?php endif; ?>
            <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><strong><?= htmlspecialchars($u['name']) ?></strong></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= htmlspecialchars($u['phone'] ?? '—') ?></td>
                <td><?= htmlspecialchars($u['city'] ?? '—') ?></td>
                <td>
                    <?php if ($u['is_verified']): ?>
                        <span class="badge bg-success">Yes</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">No</span>
                    <?php endif; ?>
                </td>
                <td style="font-size:.8rem;"><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="/admin/users/edit/<?= $u['id'] ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="/admin/users/delete/<?= $u['id'] ?>" method="POST"
                              onsubmit="return confirm('Delete <?= htmlspecialchars($u['name']) ?>?')">
                            <button type="submit" class="btn btn-sm btn-danger">
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

<?php require __DIR__ . '/footer.php'; ?>