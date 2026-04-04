<?php $pageTitle = 'Login'; ?>
<?php require __DIR__ . '/../includes/head.php'; ?>

<div class="container-fluid">
    <div class="row min-vh-100">
        <!-- Left Side - Dark Panel (Hidden on Mobile) -->
        <div class="col-lg-5 d-none d-lg-flex bg-dark text-white p-5">
            <div class="d-flex flex-column justify-content-between w-100">
                <!-- Logo -->
                <a href="/" class="d-flex align-items-center text-decoration-none text-white">
                    <div class="logo-icon">
                        <i class="bi bi-cart3"></i>
                    </div>
                    <span class="logo-text ms-2 text-white">SecondHand<span class="text-brand">Bazaar</span></span>
                </a>

                <!-- Main Content -->
                <div>
                    <h2 class="display-6 fw-bold mb-4">India's most trusted<br />secondhand marketplace</h2>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>OTP-verified buyers and sellers</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>Free to list — no commission taken</span>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-muted small mb-0">© <?= date('Y') ?> SecondHand Bazaar</p>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="col-lg-7 d-flex align-items-center justify-content-center p-4">
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
                <div class="card border shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="h4 fw-bold mb-1">Welcome back</h1>
                        <p class="text-muted mb-4">Sign in to your account to continue</p>

                        <!-- Error Messages - Very Visible -->
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger auth-alert" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Error!</strong>
                                <ul class="mb-0 mt-2 ps-3">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= htmlspecialchars($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php if (!empty($unverified)): ?>
                                    <hr class="my-2">
                                    <form action="/resend-otp" method="POST" class="mb-0">
                                        <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-envelope me-1"></i>Resend verification OTP
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Success Message - Very Visible -->
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
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?= htmlspecialchars($email ?? '') ?>"
                                    placeholder="name@example.com" required>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="password" class="form-label fw-semibold mb-0">Password</label>
                                    <a href="/forgot-password" class="text-decoration-none small">Forgot password?</a>
                                </div>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Enter your password" required>
                            </div>

                            <button type="submit" class="btn btn-brand w-100 py-2 fw-semibold">
                                Sign In
                            </button>
                        </form>

                        <p class="text-center mt-4 mb-0 text-muted small">
                            New to SecondHand Bazaar?
                            <a href="/register" class="text-decoration-none fw-semibold">Create account</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>