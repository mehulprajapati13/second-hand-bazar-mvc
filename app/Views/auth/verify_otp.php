<?php $pageTitle = 'Verify OTP'; ?>
<?php require __DIR__ . '/../includes/head.php'; ?>

<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center" style="background-color: #f8f9fa;">
    <div class="card shadow-sm" style="max-width: 400px; width: 100%;">
        <div class="card-body p-4">
            <!-- Title -->
            <div class="text-center mb-4">
                <h3 class="card-title mb-2">Check your email</h3>
                <p class="text-muted small">We sent a 6-digit OTP to your email address</p>
                <?php if (!empty($email)): ?>
                    <p class="text-muted small fw-semibold mt-2"><?= htmlspecialchars($email) ?></p>
                <?php endif; ?>
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
            <form action="/verify-otp" method="POST">
                <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>" />

                <div class="mb-3">
                    <label for="otp" class="form-label text-center d-block">Enter 6-digit OTP</label>
                    <input id="otp" name="otp" type="text" maxlength="6" class="form-control text-center fs-5"
                        inputmode="numeric" autocomplete="one-time-code"
                        placeholder="000000" required />
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg">Verify OTP</button>
            </form>

            <!-- Resend OTP -->
            <div class="text-center mt-4 pt-3 border-top">
                <small class="text-muted d-block mb-2">Didn't receive the OTP?</small>
                <form action="/resend-otp" method="POST" style="display: inline;">
                    <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>" />
                    <button type="submit" class="btn btn-link btn-sm p-0">Resend OTP</button>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center mt-3">
                <small><a href="/login">← Back to login</a></small>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>