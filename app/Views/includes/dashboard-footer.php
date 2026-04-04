        </div><!-- End Page Content -->

        <!-- Footer -->
        <footer class="footer bg-white border-top py-3 mt-auto">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <small class="text-muted">© <?= date('Y') ?> SecondHand Bazaar · Built for circular commerce in India</small>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <small>
                            <a href="#" class="text-muted text-decoration-none me-3">Privacy</a>
                            <a href="#" class="text-muted text-decoration-none me-3">Terms</a>
                            <a href="mailto:support@secondhandbazaar.com" class="text-muted text-decoration-none">Support</a>
                        </small>
                    </div>
                </div>
            </div>
        </footer>
        </div><!-- End Main Content -->
        </div><!-- End Dashboard Wrapper -->

        <!-- Mobile Sidebar Offcanvas -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body p-0">
                <nav class="sidebar-nav">
                    <a href="/dashboard" class="nav-link <?= str_starts_with($currentPath, '/dashboard') ? 'active' : '' ?>">
                        <i class="bi bi-house-door"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="/browse" class="nav-link <?= str_starts_with($currentPath, '/browse') ? 'active' : '' ?>">
                        <i class="bi bi-grid"></i>
                        <span>Browse Items</span>
                    </a>
                    <a href="/items" class="nav-link <?= str_starts_with($currentPath, '/items') ? 'active' : '' ?>">
                        <i class="bi bi-list-ul"></i>
                        <span>My Listings</span>
                    </a>
                    <a href="/requests" class="nav-link <?= str_starts_with($currentPath, '/requests') ? 'active' : '' ?>">
                        <i class="bi bi-chat-dots"></i>
                        <span>Requests</span>
                    </a>
                    <a href="/profile" class="nav-link <?= str_starts_with($currentPath, '/profile') ? 'active' : '' ?>">
                        <i class="bi bi-person"></i>
                        <span>Profile</span>
                    </a>
                </nav>
                <div class="p-3 border-top">
                    <a href="/items/add" class="btn btn-brand w-100 mb-2">
                        <i class="bi bi-plus-lg me-1"></i> New Listing
                    </a>
                    <a href="/logout" class="btn btn-outline-danger w-100">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>

        </html>