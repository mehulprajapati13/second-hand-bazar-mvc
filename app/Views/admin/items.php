<?php require __DIR__ . '/header.php'; ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 style="font-weight:800;color:#1e293b;margin:0;">All Items</h4>
    <span class="badge bg-primary"><?= count($items) ?> Items</span>
</div>

<div class="admin-table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>name</th>
                <th>Email</th>
                <th>Title</th>
                <th>desciption</th>
                <th>price</th>
                <th>mode</th>
                <th>City</th>
                <th>Registered</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($items)): ?>
                <tr>
                    <td colspan="10" class="text-center py-4 text-muted">No users found.</td>
                </tr>
            <?php endif; ?>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['seller_name'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($item['seller_email'] ?? '—') ?></td>
                    <td>
                        <div style="font-weight:600;"><?= htmlspecialchars($item['title']) ?></div>
                    </td>
                    <td><?= htmlspecialchars($item['description']) ?></td>
                    <td><?= htmlspecialchars($item['price'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($item['mode'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($item['city'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($item['created_at'] ?? '—') ?></td>
                    <td>
                        <form action="/admin/items/delete/<?= $item['id'] ?>" method="POST"
                            onsubmit="return confirm('Delete <?= htmlspecialchars($item['title']) ?>?')">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                    
                </tr>   
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/footer.php'; ?>