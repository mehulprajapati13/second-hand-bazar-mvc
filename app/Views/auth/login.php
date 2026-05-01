<?php $pageTitle = 'Login'; ?>
<?php require __DIR__ . '/../includes/head.php'; ?>

<div class="container-fluid">
    <div class="row min-vh-100">
        <!-- Left Side - Premium Gradient Panel (Hidden on Mobile) -->
        <div class="col-lg-5 d-none d-lg-flex auth-panel-left">
            <!-- Floating decorative shapes -->
            <div class="auth-shape auth-shape-1"></div>
            <div class="auth-shape auth-shape-2"></div>
            <div class="auth-shape auth-shape-3"></div>

            <div class="d-flex flex-column justify-content-between w-100" style="position:relative;z-index:2;">
                <!-- Logo -->
                <a href="/" class="d-flex align-items-center text-decoration-none text-white">
                    <div class="logo-icon">
                        <i class="bi bi-cart3"></i>
                    </div>
                    <span class="logo-text ms-2 text-white">SecondHand<span style="color:var(--accent-gold);">Bazaar</span></span>
                </a>

                <!-- Main Content -->
                <div>
                    <h2 class="display-6 fw-bold mb-4" style="line-height:1.15;letter-spacing:-0.02em;">India's most trusted<br />secondhand marketplace</h2>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="auth-check-icon"><i class="bi bi-check-lg"></i></div>
                            <span style="font-size:0.95rem;">OTP-verified buyers and sellers</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="auth-check-icon"><i class="bi bi-check-lg"></i></div>
                            <span style="font-size:0.95rem;">Free to list — no commission taken</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="auth-check-icon"><i class="bi bi-check-lg"></i></div>
                            <span style="font-size:0.95rem;">Safe local handovers with verified accounts</span>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <p class="small mb-0" style="color:rgba(255,255,255,0.4);">© <?= date('Y') ?> SecondHand Bazaar</p>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="col-lg-7 d-flex align-items-center justify-content-center p-4" style="background:var(--bg-main);">
            <div class="w-100" style="max-width: 400px;">
                <!-- Mobile Logo -->
                <div class="text-center mb-4 d-lg-none">
                    <div class="logo-icon d-inline-flex">
                        <i class="bi bi-cart3"></i>
                    </div>
                    <div class="mt-2">
                        <span class="logo-text">SecondHand<span class="text-brand">Bazaar</span></span>
                    </div>
                </div>

                <!-- Card -->
                <div class="card auth-card">
                    <div class="card-body p-4">
                        <h1 class="h4 fw-bold mb-1">Welcome back</h1>
                        <p class="text-muted mb-4">Sign in to your account to continue</p>

                        <!-- General error (non-field errors like wrong password) -->
                        <?php if (!empty($errors['_general'])): ?>
                            <div class="general-error">
                                <i class="bi bi-exclamation-circle"></i>
                                <span><?= htmlspecialchars($errors['_general']) ?></span>
                                <?php if (!empty($unverified)): ?>
                                    <form action="/resend-otp" method="POST" class="ms-auto mb-0">
                                        <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-envelope me-1"></i>Resend OTP
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Success Message -->
                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success auth-alert" role="alert">
                                <i class="bi bi-check2 alert-icon"></i>
                                <strong>Success!</strong> <?= htmlspecialchars($success) ?>
                            </div>
                        <?php endif; ?>

                        <!-- Login Form -->
                        <form action="/login" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email address</label>
                                <input type="email" class="form-control <?= !empty($errors['email']) ? 'is-invalid' : '' ?>" id="email" name="email"
                                    value="<?= htmlspecialchars($email ?? '') ?>"
                                    placeholder="name@example.com" >
                                <?php if (!empty($errors['email'])): ?>
                                    <span class="field-error"><?= htmlspecialchars($errors['email']) ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="password" class="form-label fw-semibold mb-0">Password</label>
                                    <a href="/forgot-password" class="text-decoration-none small" style="color:var(--brand-color);">Forgot password?</a>
                                </div>
                                <input type="password" class="form-control <?= !empty($errors['password']) ? 'is-invalid' : '' ?>" id="password" name="password"
                                    placeholder="Enter your password">
                                <?php if (!empty($errors['password'])): ?>
                                    <span class="field-error"><?= htmlspecialchars($errors['password']) ?></span>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-brand w-100 py-2 fw-semibold">
                                Sign In
                            </button>
                        </form>

                        <p class="text-center mt-4 mb-0 text-muted small">
                            New to SecondHand Bazaar?
                            <a href="/register" class="text-decoration-none fw-semibold" style="color:var(--brand-color);">Create account</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>