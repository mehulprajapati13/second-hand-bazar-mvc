<?php require __DIR__ . '/../../admin/header.php'; ?>

<div style="max-width:600px;">
    <div class="mb-4">
        <a href="/admin/dashboard" style="color:var(--admin-text-muted);font-size:0.85rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-bottom:12px;transition:color 0.2s;" onmouseover="this.style.color='var(--admin-brand)'" onmouseout="this.style.color='var(--admin-text-muted)'">
            <i class="bi bi-arrow-left"></i> Back to Users
        </a>
        <h4 style="font-weight:800;color:var(--admin-text);margin:0 0 4px;font-size:1.5rem;">Edit User</h4>
        <p style="font-size:0.9rem;color:var(--admin-text-muted);margin:0;">Update account details for <?= htmlspecialchars($user['name']) ?>.</p>
    </div>

    <!-- General error -->
    <?php if (!empty($errors['_general'])): ?>
        <div style="background:#fef2f2;border:1px solid #fecaca;color:#dc2626;padding:12px 16px;border-radius:8px;font-size:0.9rem;font-weight:500;display:flex;align-items:center;gap:10px;margin-bottom:20px;">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span><?= htmlspecialchars($errors['_general']) ?></span>
        </div>
    <?php endif; ?>

    <div class="admin-card">
        <div style="padding:32px;">
            <form method="POST" action="/admin/users/edit/<?= $user['id'] ?>">

                <div class="mb-4">
                    <label class="admin-form-label">Full Name</label>
                    <input type="text" name="name" class="admin-form-control w-100 <?= !empty($errors['name']) ? 'is-invalid' : '' ?>"
                        value="<?= htmlspecialchars($user['name']) ?>" required />
                    <?php if (!empty($errors['name'])): ?>
                        <div style="color:#dc2626;font-size:0.8rem;font-weight:500;margin-top:6px;"><?= htmlspecialchars($errors['name']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="admin-form-label">Email Address <span style="color:var(--admin-text-muted);font-weight:400;font-size:0.8rem;">(Read-only)</span></label>
                    <div style="position:relative;">
                        <i class="bi bi-envelope" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--admin-text-muted);"></i>
                        <input type="email" class="admin-form-control w-100" style="padding-left:40px;background-color:#f8fafc;color:var(--admin-text-muted);cursor:not-allowed;"
                            value="<?= htmlspecialchars($user['email']) ?>" disabled />
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="admin-form-label">Phone Number</label>
                        <input type="text" name="phone" class="admin-form-control w-100 <?= !empty($errors['phone']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="e.g. 9876543210" />
                        <?php if (!empty($errors['phone'])): ?>
                            <div style="color:#dc2626;font-size:0.8rem;font-weight:500;margin-top:6px;"><?= htmlspecialchars($errors['phone']) ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="admin-form-label">City Location</label>
                        <input type="text" name="city" class="admin-form-control w-100 <?= !empty($errors['city']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($user['city'] ?? '') ?>" placeholder="e.g. Mumbai" />
                        <?php if (!empty($errors['city'])): ?>
                            <div style="color:#dc2626;font-size:0.8rem;font-weight:500;margin-top:6px;"><?= htmlspecialchars($errors['city']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <hr style="border-color:var(--admin-border);margin:32px 0;">

                <div style="display:flex;gap:12px;">
                    <button type="submit" class="btn-admin-primary">Save Changes</button>
                    <a href="/admin/dashboard" class="btn-admin-outline" style="text-decoration:none;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../admin/footer.php'; ?>