<!-- Footer -->
<footer style="background:var(--nav-bg);color:#fff;padding:48px 0 24px;">
    <div class="container">
        <div class="row g-4">
            <!-- Brand -->
            <div class="col-lg-4 mb-3 mb-lg-0">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="logo-icon" style="background:var(--brand-color);color:#000;box-shadow:none;">
                        <i class="bi bi-cart3"></i>
                    </div>
                    <span class="logo-text text-white">SecondHand<span style="color:var(--brand-color);">Bazaar</span></span>
                </div>
                <p style="font-size:.84rem;color:rgba(255,255,255,0.5);line-height:1.7;max-width:320px;">
                    India's trusted marketplace for quality pre-owned items. Buy and sell locally with verified accounts — zero fees, zero hassle.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-6 col-lg-2">
                <h6 style="font-size:.7rem;text-transform:uppercase;letter-spacing:.08em;color:rgba(255,255,255,0.35);margin-bottom:14px;font-weight:700;">Platform</h6>
                <div class="d-flex flex-column gap-2">
                    <a href="/register" style="color:rgba(255,255,255,0.6);font-size:.84rem;text-decoration:none;transition:color .2s;">Create Account</a>
                    <a href="/login" style="color:rgba(255,255,255,0.6);font-size:.84rem;text-decoration:none;transition:color .2s;">Sign In</a>
                </div>
            </div>

            <!-- Support -->
            <div class="col-6 col-lg-2">
                <h6 style="font-size:.7rem;text-transform:uppercase;letter-spacing:.08em;color:rgba(255,255,255,0.35);margin-bottom:14px;font-weight:700;">Support</h6>
                <div class="d-flex flex-column gap-2">
                    <a href="#" style="color:rgba(255,255,255,0.6);font-size:.84rem;text-decoration:none;">Privacy Policy</a>
                    <a href="#" style="color:rgba(255,255,255,0.6);font-size:.84rem;text-decoration:none;">Terms of Use</a>
                </div>
            </div>

            <!-- Badge -->
            <div class="col-lg-4 text-lg-end">
                <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:10px 16px;margin-bottom:12px;">
                    <span style="font-size:1.1rem;">🇮🇳</span>
                    <div>
                        <div style="font-size:.75rem;font-weight:700;color:rgba(255,255,255,0.8);">Made in India</div>
                        <div style="font-size:.65rem;color:rgba(255,255,255,0.4);">Built for Indian sellers</div>
                    </div>
                </div>
            </div>
        </div>

        <hr style="border-color:rgba(255,255,255,0.08);margin:24px 0 16px;">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <small style="color:rgba(255,255,255,0.3);">© <?= date('Y') ?> SecondHand Bazaar. All rights reserved.</small>
            <small style="color:rgba(255,255,255,0.25);">v2.0</small>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>