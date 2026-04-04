<?php $pageTitle = 'Buy & Sell Pre-Owned Items'; ?>
<?php require __DIR__ . '/includes/head.php'; ?>
<?php require __DIR__ . '/includes/navigation.php'; ?>

<!-- Hero Section -->
<section class="hero-section landing-hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <!-- Left: Hero Text -->
            <div class="col-lg-7">
                <span class="landing-chip">
                    <i class="bi bi-shield-check"></i>
                    Verified local marketplace
                </span>
                <h1 class="landing-title fw-bold text-white">
                    Give Good Things
                    <strong>A Second Life</strong>
                </h1>
                <p class="landing-sub">
                    List in minutes, connect with real people nearby, and close deals safely with verified accounts.
                </p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="/register" class="btn btn-brand btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>List Your First Item
                    </a>
                    <a href="/login" class="btn btn-outline-light btn-lg">
                        Sign In <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
                <div class="landing-metrics">
                    <?php foreach (
                        [
                            ['10k+', 'Monthly local buyers'],
                            ['2 min', 'Average listing time'],
                            ['100%', 'OTP verified accounts'],
                        ] as [$count, $label]
                    ): ?>
                        <div class="landing-metric">
                            <strong><?= $count ?></strong>
                            <span><?= $label ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Right: Feature Card -->
            <div class="col-lg-5">
                <div class="landing-panel">
                    <h5 class="card-title text-uppercase fw-bold small text-muted mb-3">Why People Prefer This Platform</h5>
                    <?php foreach (
                        [
                            ['bi-shield-lock', 'Safe and Verified', 'All accounts are verified before posting or requesting.'],
                            ['bi-geo-alt', 'Local Discovery', 'Find buyers and sellers in your own city quickly.'],
                            ['bi-chat-dots', 'Request First Model', 'Approve or decline buyer requests on your terms.'],
                            ['bi-lightning-charge', 'Fast Listing Flow', 'Post an item with details and photo in a couple of minutes.'],
                        ] as [$icon, $title, $desc]
                    ): ?>
                        <div class="landing-panel-item">
                            <div class="landing-panel-icon">
                                <i class="bi <?= $icon ?>"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1"><?= $title ?></h6>
                                <p class="text-muted small mb-0"><?= $desc ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <a href="/register" class="btn btn-brand w-100 mt-2">
                        Create Free Account <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="landing-section bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">How It Works</h2>
            <p class="text-muted">Simple flow built for everyday sellers and local buyers</p>
        </div>
        <div class="row g-4">
            <?php foreach (
                [
                    ['01', 'Create your account', 'Sign up using your email and complete OTP verification.'],
                    ['02', 'Post your item', 'Add title, price, city and photo. Your listing goes live instantly.'],
                    ['03', 'Review requests', 'Check buyer requests and approve the one you trust.'],
                    ['04', 'Complete the handover', 'Meet locally, hand over item, and mark it sold.'],
                ] as [$num, $title, $desc]
            ): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="landing-step">
                        <div class="landing-step-number"><?= $num ?></div>
                        <h5 class="fw-bold mb-2"><?= $title ?></h5>
                        <p class="text-muted small mb-0"><?= $desc ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="landing-section">
    <div class="container">
        <div class="landing-cta text-center">
            <h2 class="fw-bold mb-3">Ready to Post Your First Listing?</h2>
            <p class="lead mb-4" style="opacity: 0.92;">Start free, connect with local buyers, and sell confidently.</p>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="/register" class="btn btn-light btn-lg fw-bold">Create Free Account</a>
                <a href="/login" class="btn btn-outline-light btn-lg">Sign In</a>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>