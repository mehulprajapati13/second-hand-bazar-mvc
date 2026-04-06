<?php $pageTitle = 'Forgot Password'; ?>
<?php require __DIR__ . '/../includes/head.php'; ?>

<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center" style="background-color: #f8f9fa;">
    <div class="card shadow-sm" style="max-width: 400px; width: 100%;">
        <div class="card-body p-4">
            <!-- Title -->
            <div class="text-center mb-4">
                <h3 class="card-title mb-2">Forgot your password?</h3>
                <p class="text-muted small">Enter your email and we'll send a reset OTP</p>
            </div>

            <!-- Errors -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <div><?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
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
            <form action="/forgot-password" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input id="email" name="email" type="email" class="form-control"
                        value="<?= htmlspecialchars($email ?? '') ?>"
                        placeholder="name@example.com" />
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg">Send Reset OTP</button>
            </form>

            <!-- Footer -->
            <div class="text-center mt-3">
                <small>Remember your password? <a href="/login">Sign in</a></small>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>