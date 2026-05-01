<?php $pageTitle = 'Reset Password'; ?>
<?php require __DIR__ . '/../includes/head.php'; ?>

<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg, var(--bg-main) 0%, var(--bg-muted) 100%);">
    <div class="auth-center-card">
        <!-- Brand Icon -->
        <div class="text-center mb-4">
            <div class="logo-icon d-inline-flex" style="width:52px;height:52px;font-size:1.3rem;border-radius:16px;">
                <i class="bi bi-lock-fill"></i>
            </div>
        </div>

        <div class="card auth-card" style="max-width:420px;width:100%;">
            <div class="card-body p-4">

                <!-- Title -->
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-2" style="font-size:1.25rem;">Reset Password</h3>
                    <p class="text-muted small">
                        Enter the 6-digit OTP sent to
                        <strong style="color:var(--brand-color);"><?= htmlspecialchars($email ?? '') ?></strong>
                        and set your new password.
                    </p>
                </div>

                <!-- General error -->
                <?php if (!empty($errors['_general'])): ?>
                    <div class="general-error">
                        <i class="bi bi-exclamation-circle"></i>
                        <span><?= htmlspecialchars($errors['_general']) ?></span>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form action="/reset-password" method="POST">

                    <!-- Hidden email — carried from session -->
                    <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>" />

                    <!-- OTP field -->
                    <div class="mb-3">
                        <label for="otp" class="form-label fw-semibold">
                            Enter OTP <span class="text-danger">*</span>
                        </label>
                        <input id="otp" name="otp" type="text"
                               class="form-control text-center otp-input <?= !empty($errors['otp']) ? 'is-invalid' : '' ?>"
                               placeholder="_ _ _ _ _ _"
                               maxlength="6"
                               inputmode="numeric"
                               autocomplete="one-time-code"
                               required />
                        <?php if (!empty($errors['otp'])): ?>
                            <span class="field-error"><?= htmlspecialchars($errors['otp']) ?></span>
                        <?php else: ?>
                            <span class="form-hint">Check your email inbox for the 6-digit OTP.</span>
                        <?php endif; ?>
                    </div>

                    <!-- New Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">
                            New Password <span class="text-danger">*</span>
                        </label>
                        <input id="password" name="password" type="password"
                               class="form-control <?= !empty($errors['password']) ? 'is-invalid' : '' ?>"
                               placeholder="Min 8 characters"
                               required />
                        <?php if (!empty($errors['password'])): ?>
                            <span class="field-error"><?= htmlspecialchars($errors['password']) ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label fw-semibold">
                            Confirm Password <span class="text-danger">*</span>
                        </label>
                        <input id="confirm_password" name="confirm_password" type="password"
                               class="form-control <?= !empty($errors['confirm_password']) ? 'is-invalid' : '' ?>"
                               placeholder="Re-enter new password"
                               required />
                        <?php if (!empty($errors['confirm_password'])): ?>
                            <span class="field-error"><?= htmlspecialchars($errors['confirm_password']) ?></span>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-brand w-100 py-2 fw-semibold">
                        Reset Password
                    </button>
                </form>

                <!-- Resend OTP link -->
                <div class="text-center mt-3">
                    <small class="text-muted">Didn't receive OTP?
                        <a href="/forgot-password" class="text-decoration-none fw-semibold" style="color:var(--brand-color);">Send again</a>
                    </small>
                </div>

                <div class="text-center mt-2">
                    <small><a href="/login" class="text-decoration-none" style="color:var(--brand-color);">← Back to login</a></small>
                </div>

            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>