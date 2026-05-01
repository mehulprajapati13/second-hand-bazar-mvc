<?php $pageTitle = 'Verify OTP'; ?>
<?php require __DIR__ . '/../includes/head.php'; ?>

<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg, var(--bg-main) 0%, var(--bg-muted) 100%);">
    <div class="auth-center-card">
        <!-- Brand Icon -->
        <div class="text-center mb-4">
            <div class="logo-icon d-inline-flex" style="width:52px;height:52px;font-size:1.3rem;border-radius:16px;">
                <i class="bi bi-shield-check"></i>
            </div>
        </div>

        <div class="card auth-card" style="max-width:400px;width:100%;">
            <div class="card-body p-4">
                <!-- Title -->
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-2" style="font-size:1.25rem;">Check your email</h3>
                    <p class="text-muted small">We sent a 6-digit OTP to your email address</p>
                    <?php if (!empty($email)): ?>
                        <p class="small fw-semibold mt-2" style="color:var(--brand-color);"><?= htmlspecialchars($email) ?></p>
                    <?php endif; ?>
                </div>

                <!-- General error -->
                <?php if (!empty($errors['_general'])): ?>
                    <div class="general-error">
                        <i class="bi bi-exclamation-circle"></i>
                        <span><?= htmlspecialchars($errors['_general']) ?></span>
                    </div>
                <?php endif; ?>

                <!-- Success -->
                <?php if (!empty($message)): ?>
                    <div class="alert alert-success auth-alert mb-3" role="alert">
                        <i class="bi bi-check2 alert-icon"></i>
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form action="/verify-otp" method="POST">
                    <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>" />

                    <div class="mb-3">
                        <label for="otp" class="form-label text-center d-block fw-semibold">Enter 6-digit OTP</label>
                        <input id="otp" name="otp" type="text" maxlength="6"
                            class="form-control text-center otp-input <?= !empty($errors['otp']) ? 'is-invalid' : '' ?>"
                            inputmode="numeric" autocomplete="one-time-code"
                            placeholder="000000" required />
                        <?php if (!empty($errors['otp'])): ?>
                            <span class="field-error"><?= htmlspecialchars($errors['otp']) ?></span>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-brand w-100 py-2 fw-semibold">Verify OTP</button>
                </form>

                <!-- Resend OTP -->
                <div class="text-center mt-4 pt-3 border-top">
                    <small class="text-muted d-block mb-2">Didn't receive the OTP?</small>
                    <form action="/resend-otp" method="POST" style="display: inline;">
                        <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>" />
                        <button type="submit" class="btn btn-link btn-sm p-0" style="color:var(--brand-color);font-weight:600;">Resend OTP</button>
                    </form>
                </div>

                <!-- Footer -->
                <div class="text-center mt-3">
                    <small><a href="/login" class="text-decoration-none" style="color:var(--brand-color);">← Back to login</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>