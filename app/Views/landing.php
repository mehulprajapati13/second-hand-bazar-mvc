<?php $pageTitle = 'Buy & Sell Pre-Owned Items'; ?>
<?php require __DIR__ . '/includes/head.php'; ?>
<?php require __DIR__ . '/includes/navigation.php'; ?>

<!-- Hero Section -->
<section class="hero-section landing-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="landing-chip">
                    <i class="bi bi-patch-check-fill"></i>
                    India's #1 Verified Local Marketplace
                </div>
                <h1 class="landing-title">
                    Buy & Sell<br>
                    <strong>Pre-Owned Goods</strong><br>
                    Near You
                </h1>
                <p class="landing-sub">
                    List your items in under 2 minutes, connect with verified buyers in your city, and close deals safely — all for free.
                </p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="/register" class="btn btn-light btn-lg px-4 py-2 fw-bold" style="border-radius:12px;font-size:.95rem;">
                        <i class="bi bi-plus-circle me-2"></i>Start Selling Free
                    </a>
                    <a href="/login" class="btn btn-outline-light btn-lg px-4 py-2" style="border-radius:12px;font-size:.95rem;">
                        Browse Items <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
                <div class="landing-metrics">
                    <?php foreach ([
                        ['bi-people-fill', '10,000+', 'Active Users'],
                        ['bi-clock-fill', '< 2 min', 'To List an Item'],
                        ['bi-shield-fill-check', '100%', 'OTP Verified'],
                    ] as [$icon, $count, $label]): ?>
                        <div class="landing-metric">
                            <i class="bi <?= $icon ?>" style="color:var(--brand-light);font-size:1rem;"></i>
                            <strong><?= $count ?></strong>
                            <span><?= $label ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-lg-6 d-none d-lg-block">
                <div class="landing-panel" style="position:relative;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                        <div style="width:10px;height:10px;border-radius:50%;background:#ef4444;"></div>
                        <div style="width:10px;height:10px;border-radius:50%;background:#f59e0b;"></div>
                        <div style="width:10px;height:10px;border-radius:50%;background:#22c55e;"></div>
                        <span style="margin-left:auto;font-size:.7rem;color:var(--text-muted);font-weight:600;">LIVE PREVIEW</span>
                    </div>

                    <?php foreach ([
                        ['iPhone 13 Pro', '₹42,000', 'Mumbai', 'bi-phone', 'Sell'],
                        ['Study Table (Wooden)', '₹3,500', 'Delhi', 'bi-house-door', 'Sell'],
                        ['Canon DSLR Camera', '₹800/day', 'Bangalore', 'bi-camera', 'Rent'],
                    ] as $i => [$name, $price, $city, $icon, $type]): ?>
                        <div style="display:flex;align-items:center;gap:14px;padding:14px;background:#f8faf9;border-radius:12px;margin-bottom:<?= $i < 2 ? '10' : '0' ?>px;border:1px solid #e2e8f0;transition:all .2s;" class="landing-mock-item">
                            <div style="width:48px;height:48px;border-radius:12px;background:var(--brand-lighter);display:flex;align-items:center;justify-content:center;color:var(--brand-color);font-size:1.2rem;flex-shrink:0;">
                                <i class="bi <?= $icon ?>"></i>
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div style="font-weight:600;font-size:.88rem;color:var(--text-primary);"><?= $name ?></div>
                                <div style="font-size:.75rem;color:var(--text-muted);margin-top:1px;">
                                    <i class="bi bi-geo-alt" style="font-size:.65rem;"></i> <?= $city ?>
                                    <span style="margin-left:8px;background:var(--brand-lighter);color:var(--brand-dark);padding:1px 6px;border-radius:4px;font-size:.6rem;font-weight:700;"><?= $type ?></span>
                                </div>
                            </div>
                            <div style="font-weight:800;color:var(--brand-color);font-size:.95rem;white-space:nowrap;"><?= $price ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trust Strip -->
<section style="background:#fff;border-bottom:1px solid var(--border);padding:20px 0;">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center gap-4 gap-md-5 align-items-center" style="font-size:.85rem;color:var(--text-muted);font-weight:500;">
            <?php foreach ([
                ['bi-shield-lock-fill', 'Verified Accounts'],
                ['bi-lightning-charge-fill', 'Instant Listing'],
                ['bi-cash-coin', 'Zero Commission'],
                ['bi-geo-alt-fill', 'Local Discovery'],
                ['bi-chat-dots-fill', 'Request-First Model'],
            ] as [$icon, $text]): ?>
                <span><i class="bi <?= $icon ?> me-1" style="color:var(--brand-color);"></i><?= $text ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="landing-section" style="background:#fff;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge badge-green mb-2" style="font-size:.75rem;padding:6px 14px;">Simple Process</span>
            <h2 class="fw-bold" style="font-size:1.8rem;">How It Works</h2>
            <p class="text-muted mx-auto" style="max-width:480px;">List, connect, and sell — all within your city. No middlemen, no hidden fees.</p>
        </div>
        <div class="row g-4">
            <?php foreach ([
                ['01', 'bi-person-plus-fill', 'Create Account', 'Sign up with your email and verify via OTP. Takes under 30 seconds.'],
                ['02', 'bi-camera-fill', 'Post Your Item', 'Add title, price, city, and a photo. Your listing goes live instantly.'],
                ['03', 'bi-chat-left-text-fill', 'Get Requests', 'Interested buyers send requests. You choose who to approve.'],
                ['04', 'bi-handshake', 'Meet & Complete', 'Connect with the buyer, meet locally, and hand over the item.'],
            ] as $i => [$num, $icon, $title, $desc]): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="landing-step" style="animation:fadeInUp .5s ease <?= $i * 0.1 ?>s both;">
                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                            <div class="landing-step-number"><?= $num ?></div>
                            <i class="bi <?= $icon ?>" style="font-size:1.3rem;color:var(--brand-color);"></i>
                        </div>
                        <h5 class="fw-bold mb-2" style="font-size:1rem;"><?= $title ?></h5>
                        <p class="text-muted small mb-0" style="line-height:1.6;"><?= $desc ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Features Grid -->
<section class="landing-section" style="background:var(--bg-main);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge badge-blue mb-2" style="font-size:.75rem;padding:6px 14px;">Why Choose Us</span>
            <h2 class="fw-bold" style="font-size:1.8rem;">Built for Real People</h2>
        </div>
        <div class="row g-4">
            <?php foreach ([
                ['bi-shield-lock', 'var(--green-bg)', 'var(--green-text)', 'Safe & Verified', 'Every account is OTP verified. No spam, no fake profiles — just real people.'],
                ['bi-geo-alt', 'var(--blue-bg)', 'var(--blue-text)', 'Hyper-Local', 'Discover items in your own city. No cross-country shipping hassles.'],
                ['bi-chat-dots', 'var(--purple-bg)', 'var(--purple-text)', 'Request-First', 'Buyers request, sellers approve. You stay in control of every deal.'],
                ['bi-lightning-charge', 'var(--orange-bg)', 'var(--orange-text)', 'Lightning Fast', 'Post an item in under 2 minutes. No complex forms or approvals.'],
            ] as [$icon, $bg, $clr, $title, $desc]): ?>
                <div class="col-md-6">
                    <div class="feature-card" style="display:flex;gap:18px;align-items:flex-start;">
                        <div style="width:50px;height:50px;border-radius:14px;background:<?= $bg ?>;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="bi <?= $icon ?>" style="font-size:1.3rem;color:<?= $clr ?>;"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1" style="font-size:1rem;"><?= $title ?></h5>
                            <p class="text-muted small mb-0" style="line-height:1.65;"><?= $desc ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="landing-section" style="background:#fff;">
    <div class="container">
        <div class="landing-cta">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-3 mb-lg-0">
                    <h2 class="fw-bold mb-2" style="font-size:1.6rem;">Ready to Declutter & Earn?</h2>
                    <p class="mb-0" style="opacity:0.9;font-size:.95rem;">Join thousands of sellers in your city. Free to list, zero commission.</p>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <a href="/register" class="btn btn-light btn-lg fw-bold px-4" style="border-radius:12px;">Create Free Account</a>
                    <a href="/login" class="btn btn-outline-light btn-lg px-4 ms-2" style="border-radius:12px;">Sign In</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>