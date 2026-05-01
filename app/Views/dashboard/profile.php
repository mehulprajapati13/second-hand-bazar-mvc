<?php
$pageTitle = 'Profile';
require __DIR__ . '/../includes/head.php';
require __DIR__ . '/../includes/navigation.php';
?>

<div class="bg-gray-50/50 min-h-[calc(100vh-72px)] py-8 font-sans">
    <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
        <div class="row g-6">
            <!-- Sidebar -->
            <div class="col-lg-3 transition-all duration-300">
                <?php require __DIR__ . '/../includes/account-sidebar.php'; ?>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 transition-all duration-300">
                
                <div class="flex items-center gap-2 text-sm font-medium text-gray-500 mb-6">
                    <a href="/dashboard" class="text-orange-500 hover:text-orange-600 no-underline">Home</a>
                    <i class="bi bi-chevron-right text-[10px]"></i>
                    <span class="text-gray-900">Profile Settings</span>
                </div>

                <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight m-0 mb-1">Profile Settings</h1>
                        <p class="text-gray-500 font-medium m-0">Update your personal details and public profile.</p>
                    </div>
                </div>

                <!-- Profile Header Card -->
                <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm mb-8 animate-[fadeInUp_0.4s_ease-out]">
                    <div class="h-32 bg-gradient-to-br from-orange-300 to-orange-500 relative">
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMSkiIHN0cm9rZS13aWR0aD0iMSI+PHBhdGggZD0iTTAgMjRoMjRWMHoiLz48L3N2Zz4=')] opacity-30"></div>
                    </div>
                    <div class="relative px-8 pb-8 -mt-12">
                        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-4xl font-extrabold text-orange-500 shadow-xl border-4 border-white mb-4">
                            <?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?>
                        </div>
                        <h3 class="text-2xl font-extrabold text-gray-900 mb-1"><?= htmlspecialchars($user['name'] ?? '—') ?></h3>
                        <p class="text-gray-500 font-medium mb-3"><?= htmlspecialchars($user['email'] ?? '—') ?></p>
                        <?php if (!empty($user['city'])): ?>
                            <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 font-bold px-3 py-1.5 rounded-lg text-sm border border-emerald-100">
                                <i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($user['city']) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Edit Profile Form -->
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm mb-8 animate-[fadeInUp_0.4s_ease-out_0.1s] overflow-hidden">
                    <div class="bg-gray-50/50 border-b border-gray-100 p-6 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shadow-sm">
                            <i class="bi bi-person-lines-fill text-xl"></i>
                        </div>
                        <h4 class="font-extrabold text-gray-900 text-lg m-0">Personal Information</h4>
                    </div>
                    <div class="p-6 md:p-8">
                        <?php if (!empty($errors['_general'])): ?>
                            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl mb-6 flex items-start gap-3">
                                <i class="bi bi-exclamation-triangle-fill mt-0.5"></i>
                                <div><?= htmlspecialchars($errors['_general']) ?></div>
                            </div>
                        <?php endif; ?>

                        <form action="/profile/update" method="POST">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                                    <input type="text" name="name" class="w-full px-4 py-3 rounded-xl border <?= !empty($errors['name']) ? 'border-rose-300 bg-rose-50' : 'border-gray-200 bg-gray-50' ?> focus:bg-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors shadow-sm outline-none" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required />
                                    <?php if (!empty($errors['name'])): ?>
                                        <p class="text-rose-500 text-xs font-semibold mt-1.5"><?= htmlspecialchars($errors['name']) ?></p>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                                    <input type="email" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed shadow-sm outline-none" value="<?= htmlspecialchars($user['email'] ?? '') ?>" disabled />
                                    <p class="text-gray-400 text-xs font-medium mt-1.5 flex items-center gap-1"><i class="bi bi-lock-fill"></i> Email cannot be changed.</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel" name="phone" class="w-full px-4 py-3 rounded-xl border <?= !empty($errors['phone']) ? 'border-rose-300 bg-rose-50' : 'border-gray-200 bg-gray-50' ?> focus:bg-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors shadow-sm outline-none" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" />
                                    <?php if (!empty($errors['phone'])): ?>
                                        <p class="text-rose-500 text-xs font-semibold mt-1.5"><?= htmlspecialchars($errors['phone']) ?></p>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">City</label>
                                    <input type="text" name="city" class="w-full px-4 py-3 rounded-xl border <?= !empty($errors['city']) ? 'border-rose-300 bg-rose-50' : 'border-gray-200 bg-gray-50' ?> focus:bg-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors shadow-sm outline-none" value="<?= htmlspecialchars($user['city'] ?? '') ?>" />
                                    <?php if (!empty($errors['city'])): ?>
                                        <p class="text-rose-500 text-xs font-semibold mt-1.5"><?= htmlspecialchars($errors['city']) ?></p>
                                    <?php endif; ?>
                                </div>

                                <div class="col-span-1 md:col-span-2 mt-4 pt-6 border-t border-gray-100">
                                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-xl transition-all shadow-sm shadow-orange-500/20 hover:-translate-y-0.5 border-none cursor-pointer">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Security -->
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm animate-[fadeInUp_0.4s_ease-out_0.2s] overflow-hidden mb-8">
                    <div class="bg-gray-50/50 border-b border-gray-100 p-6 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center shadow-sm">
                            <i class="bi bi-shield-lock-fill text-xl"></i>
                        </div>
                        <h4 class="font-extrabold text-gray-900 text-lg m-0">Password & Security</h4>
                    </div>
                    <div class="p-6 md:p-8">
                        <p class="text-gray-500 font-medium mb-6 max-w-2xl">To update your password, you need to sign out and use the "Forgot Password" link on the login page. This ensures your account remains secure.</p>
                        <a href="/logout" class="inline-flex items-center gap-2 bg-white border border-red-200 text-red-600 hover:bg-red-50 hover:border-red-300 font-bold px-6 py-3 rounded-xl transition-colors no-underline">
                            <i class="bi bi-box-arrow-right"></i> Sign Out to Reset Password
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<?php require __DIR__ . '/../includes/footer.php'; ?>