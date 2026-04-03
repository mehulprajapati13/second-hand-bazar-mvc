<?php require __DIR__ . '/../dashboard/header.php'; ?>

<main class="px-4 sm:px-6 lg:px-8 py-6 space-y-6">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-gray-500">
        <a href="/dashboard" class="hover:text-brand-500">Home</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">Profile</span>
    </div>

    <!-- Success / Error Message -->
    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'updated'): ?>
    <div class="bg-green-50 border border-green-200 rounded-xl p-4">
        <p class="text-green-700 text-sm font-semibold">✓ Profile updated successfully.</p>
    </div>
    <?php endif; ?>

    <?php if (!empty($errors ?? [])): ?>
    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
        <?php foreach ($errors as $e): ?>
            <p class="text-red-700 text-sm font-semibold">• <?= htmlspecialchars($e) ?></p>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Profile Header Card -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="h-20 bg-gradient-to-r from-brand-500 to-brand-600"></div>
        <div class="px-6 pb-6">
            <div class="flex items-end justify-between -mt-8 mb-4">
                <div class="h-16 w-16 rounded-2xl border-4 border-white bg-brand-500 flex items-center justify-center text-white text-2xl font-bold shadow-sm">
                    <?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?>
                </div>
            </div>
            <h2 class="text-lg font-bold text-gray-900"><?= htmlspecialchars($user['name'] ?? '—') ?></h2>
            <p class="text-sm text-gray-500"><?= htmlspecialchars($user['email'] ?? '—') ?></p>
            <?php if (!empty($user['city'])): ?>
            <p class="text-sm text-gray-500 flex items-center gap-1 mt-1">
                <svg class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                <?= htmlspecialchars($user['city']) ?>
            </p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-3 gap-4">
        <?php foreach([
            ['Active',  $summary['active_items']   ?? 0, 'bg-green-50  border-green-200',  '✅'],
            ['Sold',    $summary['sold_items']      ?? 0, 'bg-purple-50 border-purple-200', '🏷️'],
            ['Total',   $summary['total_items']     ?? 0, 'bg-blue-50   border-blue-200',   '📦'],
        ] as [$label, $val, $cls, $ico]): ?>
        <div class="bg-white rounded-xl border <?= $cls ?> shadow-sm p-4 text-center">
            <div class="text-2xl mb-1"><?= $ico ?></div>
            <p class="text-2xl font-bold text-gray-900"><?= $val ?></p>
            <p class="text-xs text-gray-500 mt-0.5"><?= $label ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Edit Profile Form -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-sm font-bold text-gray-900">Edit Profile</h3>
            <p class="text-xs text-gray-500 mt-0.5">Update your personal details below</p>
        </div>
        <form action="/profile/update" method="POST" class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">

            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Full Name</label>
                <input type="text" name="name"
                       class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-0 outline-none transition-colors"
                       value="<?= htmlspecialchars($user['name'] ?? '') ?>" required/>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Email Address</label>
                <input type="email"
                       class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 text-gray-400 cursor-not-allowed"
                       value="<?= htmlspecialchars($user['email'] ?? '') ?>" disabled/>
                <p class="text-xs text-gray-400">Email cannot be changed.</p>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Phone Number</label>
                <input type="text" name="phone"
                       class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-0 outline-none transition-colors"
                       value="<?= htmlspecialchars($user['phone'] ?? '') ?>"/>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">City</label>
                <input type="text" name="city"
                       class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-0 outline-none transition-colors"
                       value="<?= htmlspecialchars($user['city'] ?? '') ?>"/>
            </div>

            <div class="sm:col-span-2 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-6 py-2.5 rounded-lg transition-colors shadow-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Save Changes
                </button>
            </div>

        </form>
    </div>

    <!-- Password Section -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
            <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            <h3 class="text-sm font-bold text-gray-900">Password & Security</h3>
        </div>
        <div class="p-6 space-y-4">
            <p class="text-sm text-gray-600">To change your password, use the forgot password flow from the login page.</p>
            <div class="flex flex-wrap gap-3">
                <a href="/logout"
                   class="inline-flex items-center gap-2 border border-gray-300 text-gray-600 hover:text-red-600 hover:border-red-300 hover:bg-red-50 font-semibold text-sm px-4 py-2.5 rounded-lg transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout First
                </a>
                <p class="text-xs text-gray-400 self-center">Then use "Forgot Password" on login page</p>
            </div>
        </div>
    </div>

</main>

<?php require __DIR__ . '/../dashboard/footer.php'; ?>
