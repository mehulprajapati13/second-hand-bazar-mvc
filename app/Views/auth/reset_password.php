<?php $pageTitle = 'Reset Password'; ?>
<?php require __DIR__ . '/../includes/head.php'; ?>

<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center" style="background-color: #f8f9fa;">
    <div class="card shadow-sm" style="max-width: 400px; width: 100%;">
        <div class="card-body p-4">
            <!-- Title -->
            <div class="text-center mb-4">
                <h3 class="card-title mb-2">Set new password</h3>
                <p class="text-muted small">Choose a strong password for your account</p>
            </div>

            <!-- Errors -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <div><?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Success -->
            <?php if (!empty($success)): ?>
                <div class="alert alert-success auth-alert alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-check2 alert-icon"></i>
                    <?= htmlspecialchars($success) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form action="/reset-password" method="POST">
                <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>" />
                <input type="hidden" name="otp" value="<?= htmlspecialchars($otp ?? '') ?>" />

                <div class="mb-3">
                    <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                    <input id="password" name="password" type="password" class="form-control"
                        placeholder="Min 8 characters" required />
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control"
                        placeholder="Re-enter new password" required />
                </div>

                <!-- Password requirements -->
                <div class="alert alert-info small mb-3" role="alert">
                    <strong class="d-block mb-2"><i class="bi bi-info-circle me-1"></i>Password requirements:</strong>
                    <ul class="mb-0 ps-3">
                        <li>At least 8 characters long</li>
                        <li>Contains letters and numbers</li>
                    </ul>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg">Reset Password</button>
            </form>

            <!-- Footer -->
            <div class="text-center mt-3">
                <small><a href="/login">← Back to login</a></small>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>