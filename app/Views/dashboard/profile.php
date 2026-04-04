<?php
$pageTitle = 'Profile';
require __DIR__ . '/../includes/dashboard-header.php';
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <a href="/dashboard">Home</a>
    <span class="sep">/</span>
    <span class="current">Profile</span>
</div>

<!-- Alerts -->
<?php if (isset($_GET['msg']) && $_GET['msg'] === 'updated'): ?>
<div class="alert alert-green mb-4">
    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <span><strong>Success!</strong> Profile updated successfully.</span>
</div>
<?php endif; ?>

<?php if (!empty($errors ?? [])): ?>
<div class="alert alert-red mb-4" style="flex-direction:column;gap:4px;">
    <?php foreach ($errors as $e): ?>
        <div>• <?= htmlspecialchars($e) ?></div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Profile Header Card -->
<div class="card mb-4">
    <div class="profile-cover"></div>
    <div class="profile-info">
        <div class="profile-avatar-wrap">
            <div class="profile-avatar"><?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?></div>
        </div>
        <div style="font-size:1.125rem;font-weight:700;color:var(--text-primary);"><?= htmlspecialchars($user['name'] ?? '—') ?></div>
        <div style="font-size:.875rem;color:var(--text-muted);margin-top:2px;"><?= htmlspecialchars($user['email'] ?? '—') ?></div>
        <?php if (!empty($user['city'])): ?>
        <div style="font-size:.8125rem;color:var(--text-muted);margin-top:4px;display:flex;align-items:center;gap:4px;">
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
            <?= htmlspecialchars($user['city']) ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Stats Row -->
<div class="grid-3 mb-4">
    <?php foreach ([
        ['Active',  $summary['active_items']  ?? 0, 'var(--green-bg)',  'var(--green-border)',  'var(--green-text)',  '✅'],
        ['Sold',    $summary['sold_items']    ?? 0, 'var(--purple-bg)', 'var(--purple-border)', 'var(--purple-text)', '🏷️'],
        ['Total',   $summary['total_items']   ?? 0, 'var(--blue-bg)',   'var(--blue-border)',   'var(--blue-text)',   '📦'],
    ] as [$label, $val, $bg, $bdr, $clr, $ico]): ?>
    <div class="stat-card" style="border-color:<?= $bdr ?>;background:<?= $bg ?>;">
        <div style="font-size:1.5rem;"><?= $ico ?></div>
        <div class="stat-value" style="color:<?= $clr ?>;"><?= $val ?></div>
        <div class="stat-label"><?= $label ?></div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Edit Profile Form -->
<div class="card mb-4">
    <div class="card-header">
        <div>
            <div class="card-header-title">Edit Profile</div>
            <div class="card-header-sub">Update your personal details below</div>
        </div>
    </div>
    <div class="card-body">
        <form action="/profile/update" method="POST" class="form-grid-2" style="gap:18px;">

            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control"
                       value="<?= htmlspecialchars($user['name'] ?? '') ?>" required />
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control"
                       value="<?= htmlspecialchars($user['email'] ?? '') ?>" disabled />
                <span class="form-hint">Email cannot be changed.</span>
            </div>

            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control"
                       value="<?= htmlspecialchars($user['phone'] ?? '') ?>" />
            </div>

            <div class="form-group">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control"
                       value="<?= htmlspecialchars($user['city'] ?? '') ?>" />
            </div>

            <div class="col-span-2" style="padding-top:6px;">
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Security -->
<div class="card">
    <div class="card-header">
        <div class="card-header-title" style="display:flex;align-items:center;gap:8px;">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            Password &amp; Security
        </div>
    </div>
    <div class="card-body">
        <p class="text-sm text-secondary" style="margin-bottom:14px;">To change your password, use the forgot password flow from the login page.</p>
        <div class="flex gap-3 flex-wrap items-center">
            <a href="/logout" class="btn btn-secondary" style="color:var(--red-text);border-color:var(--red-border);">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout First
            </a>
            <span class="form-hint">Then use "Forgot Password" on login page</span>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/dashboard-footer.php'; ?>
