<?php $pageTitle = 'Forgot Password'; ?>
<?php require __DIR__ . '/../includes/head.php'; ?>

<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg, var(--bg-main) 0%, var(--bg-muted) 100%);">
    <div class="auth-center-card">
        <!-- Brand Icon -->
        <div class="text-center mb-4">
            <div class="logo-icon d-inline-flex" style="width:52px;height:52px;font-size:1.3rem;border-radius:16px;">
                <i class="bi bi-key"></i>
            </div>
        </div>

        <div class="card auth-card" style="max-width:400px;width:100%;">
            <div class="card-body p-4">
                <!-- Title -->
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-2" style="font-size:1.25rem;">Forgot your password?</h3>
                    <p class="text-muted small">Enter your email and we'll send a reset OTP</p>
                </div>

                <!-- General error -->
                <?php if (!empty($errors['_general'])): ?>
                    <div class="general-error">
                        <i class="bi bi-exclamation-circle"></i>
                        <span><?= htmlspecialchars($errors['_general']) ?></span>
                    </div>
                <?php endif; ?>

                <!-- Success -->
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success auth-alert mb-3" role="alert">
                        <i class="bi bi-check2 alert-icon"></i>
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form action="/forgot-password" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email address</label>
                        <input id="email" name="email" type="email" class="form-control <?= !empty($errors['email']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($email ?? '') ?>"
                            placeholder="name@example.com" />
                        <?php if (!empty($errors['email'])): ?>
                            <span class="field-error"><?= htmlspecialchars($errors['email']) ?></span>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-brand w-100 py-2 fw-semibold">Send Reset OTP</button>
                </form>

                <!-- Footer -->
                <div class="text-center mt-3">
                    <small class="text-muted">Remember your password? <a href="/login" class="text-decoration-none fw-semibold" style="color:var(--brand-color);">Sign in</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>