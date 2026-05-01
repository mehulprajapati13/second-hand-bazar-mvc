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
                    <h2 class="display-6 fw-bold mb-4" style="line-height:1.15;letter-spacing:-0.02em;">Start selling in<br />under 2 minutes</h2>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="auth-check-icon"><i class="bi bi-check-lg"></i></div>
                            <span style="font-size:0.95rem;">Free account — no credit card needed</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="auth-check-icon"><i class="bi bi-check-lg"></i></div>
                            <span style="font-size:0.95rem;">List items and reach buyers nearby</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="auth-check-icon"><i class="bi bi-check-lg"></i></div>
                            <span style="font-size:0.95rem;">OTP verification keeps everyone safe</span>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <p class="small mb-0" style="color:rgba(255,255,255,0.4);">© <?= date('Y') ?> SecondHand Bazaar</p>
            </div>
        </div>

        <!-- Right Side - Registration Form --> 
        <div class="col-lg-7 d-flex align-items-center justify-content-center p-4" style="background:var(--bg-main);">
            <div class="w-100" style="max-width: 500px;">
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
                        <h1 class="h4 fw-bold mb-1">Create your account</h1>
                        <p class="text-muted mb-4">Join thousands of buyers and sellers in your city</p>

                        <!-- General error -->
                        <?php if (!empty($errors['_general'])): ?>
                            <div class="general-error">
                                <i class="bi bi-exclamation-circle"></i>
                                <span><?= htmlspecialchars($errors['_general']) ?></span>
                            </div>
                        <?php endif; ?>

                        <!-- Registration Form -->
                        <form action="/register" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= !empty($errors['name']) ? 'is-invalid' : '' ?>" id="name" name="name"
                                    value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                                    placeholder="Rahul Sharma">
                                <?php if (!empty($errors['name'])): ?>
                                    <span class="field-error"><?= htmlspecialchars($errors['name']) ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control <?= !empty($errors['email']) ? 'is-invalid' : '' ?>" id="email" name="email"
                                        value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                                        placeholder="name@example.com">
                                    <?php if (!empty($errors['email'])): ?>
                                        <span class="field-error"><?= htmlspecialchars($errors['email']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control <?= !empty($errors['phone']) ? 'is-invalid' : '' ?>" id="phone" name="phone"
                                        value="<?= htmlspecialchars($old['phone'] ?? '') ?>"
                                        placeholder="9876543210">
                                    <?php if (!empty($errors['phone'])): ?>
                                        <span class="field-error"><?= htmlspecialchars($errors['phone']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="city" class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= !empty($errors['city']) ? 'is-invalid' : '' ?>" id="city" name="city"
                                    value="<?= htmlspecialchars($old['city'] ?? '') ?>"
                                    placeholder="Mumbai, Delhi, Jaipur...">
                                <?php if (!empty($errors['city'])): ?>
                                    <span class="field-error"><?= htmlspecialchars($errors['city']) ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control <?= !empty($errors['password']) ? 'is-invalid' : '' ?>" id="password" name="password"
                                        placeholder="Min 8 characters">
                                    <?php if (!empty($errors['password'])): ?>
                                        <span class="field-error"><?= htmlspecialchars($errors['password']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                        placeholder="Re-enter password">
                                </div>
                            </div>

                            <!-- OTP Notice -->
                            <div class="alert alert-info auth-alert d-flex align-items-center" role="alert">
                                <i class="bi bi-shield-check me-2"></i>
                                <small>A verification OTP will be sent to your email to activate the account.</small>
                            </div>

                            <button type="submit" class="btn btn-brand w-100 py-2 fw-semibold">
                                Create Account
                            </button>
                        </form>

                        <p class="text-center mt-4 mb-0 text-muted small">
                            Already have an account?
                            <a href="/login" class="text-decoration-none fw-semibold" style="color:var(--brand-color);">Sign in →</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>