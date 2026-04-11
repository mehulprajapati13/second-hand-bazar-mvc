<?php require __DIR__ . '/../../admin/header.php'; ?>

<div style="max-width:540px;">
    <div style="margin-bottom:16px;">
        <a href="/admin/dashboard" style="color:#f97316;font-size:.875rem;font-weight:600;text-decoration:none;">
            ← Back to Users
        </a>
        <h4 style="font-weight:700;margin:8px 0 4px;">Edit User</h4>
        <p style="font-size:.875rem;color:#64748b;margin:0;">Update user details below.</p>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger mb-3">
            <?php foreach ($errors as $e): ?>
                <div><?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="admin-table" style="border-radius:12px;overflow:hidden;">
        <div style="padding:24px;">
            <form method="POST" action="/admin/users/edit/<?= $user['id'] ?>">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input type="text" name="name" class="form-control"
                        value="<?= htmlspecialchars($user['name']) ?>" required />
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email (cannot change)</label>
                    <input type="email" class="form-control bg-light"
                        value="<?= htmlspecialchars($user['email']) ?>" disabled />
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Phone</label>
                    <input type="text" name="phone" class="form-control"
                        value="<?= htmlspecialchars($user['phone'] ?? '') ?>" />
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">City</label>
                    <input type="text" name="city" class="form-control"
                        value="<?= htmlspecialchars($user['city'] ?? '') ?>" />
                </div>

                <div style="display:flex;gap:10px;margin-top:20px;">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="/admin/dashboard" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../admin/footer.php'; ?>