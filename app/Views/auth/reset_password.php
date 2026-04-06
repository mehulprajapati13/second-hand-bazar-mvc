<?php $pageTitle = 'Reset Password'; ?>
<?php require __DIR__ . '/../includes/head.php'; ?>

<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center" style="background-color: #f8f9fa;">
    <div class="card shadow-sm" style="max-width: 420px; width: 100%;">
        <div class="card-body p-4">

            <!-- Title -->
            <div class="text-center mb-4">
                <h3 class="card-title mb-2">Reset Password</h3>
                <p class="text-muted small">
                    Enter the 6-digit OTP sent to
                    <strong><?= htmlspecialchars($email ?? '') ?></strong>
                    and set your new password.
                </p>
            </div>

            <!-- Errors -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <div><?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form action="/reset-password" method="POST">

                <!-- Hidden email — carried from session -->
                <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>" />

                <!-- OTP field — VISIBLE so user can type it -->
                <div class="mb-3">
                    <label for="otp" class="form-label fw-semibold">
                        Enter OTP <span class="text-danger">*</span>
                    </label>
                    <input id="otp" name="otp" type="text"
                           class="form-control form-control-lg text-center fw-bold"
                           placeholder="_ _ _ _ _ _"
                           maxlength="6"
                           inputmode="numeric"
                           autocomplete="one-time-code"
                           required />
                    <div class="form-text">Check your email inbox for the 6-digit OTP.</div>
                </div>

                <!-- New Password -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">
                        New Password <span class="text-danger">*</span>
                    </label>
                    <input id="password" name="password" type="password"
                           class="form-control"
                           placeholder="Min 8 characters"
                           required />
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="confirm_password" class="form-label fw-semibold">
                        Confirm Password <span class="text-danger">*</span>
                    </label>
                    <input id="confirm_password" name="confirm_password" type="password"
                           class="form-control"
                           placeholder="Re-enter new password"
                           required />
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg">
                    Reset Password
                </button>
            </form>

            <!-- Resend OTP link -->
            <div class="text-center mt-3">
                <small class="text-muted">Didn't receive OTP?
                    <a href="/forgot-password">Send again</a>
                </small>
            </div>

            <div class="text-center mt-2">
                <small><a href="/login">← Back to login</a></small>
            </div>

        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>