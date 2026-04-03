<?php require __DIR__ . '/../dashboard/header.php'; ?>

<main class="px-4 sm:px-6 lg:px-8 py-6 space-y-6">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-gray-500">
        <a href="/dashboard" class="hover:text-brand-500">Home</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">Dashboard</span>
    </div>

    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-brand-500 to-brand-600 rounded-2xl p-6 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <p class="text-brand-100 text-sm">Welcome back 👋</p>
            <h1 class="text-xl sm:text-2xl font-bold mt-0.5"><?= htmlspecialchars($_SESSION['user']['name'] ?? 'User') ?></h1>
            <p class="text-brand-100 text-sm mt-1">Manage your listings and track your marketplace activity.</p>
        </div>
        <div class="flex gap-2 flex-shrink-0">
            <a href="/items/add" class="inline-flex items-center gap-1.5 bg-white text-brand-600 hover:bg-brand-50 font-semibold px-4 py-2 rounded-lg text-sm transition-colors shadow-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Add Listing
            </a>
            <a href="/browse" class="inline-flex items-center gap-1.5 bg-brand-400/30 border border-white/30 text-white hover:bg-brand-400/50 font-semibold px-4 py-2 rounded-lg text-sm transition-colors">
                Browse
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <?php
    $cards = [
        ['Total Items',      $summary['total_items'] ?? 0,      'bg-blue-50 text-blue-600',   '<path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>'],
        ['Active Items',     $summary['active_items'] ?? 0,     'bg-green-50 text-green-600', '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
        ['Reserved',         $summary['reserved_items'] ?? 0,   'bg-yellow-50 text-yellow-600','<path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>'],
        ['Sold',             $summary['sold_items'] ?? 0,       'bg-purple-50 text-purple-600','<path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>'],
        ['Requests Received',$summary['requests_received'] ?? 0,'bg-orange-50 text-orange-600','<path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>'],
        ['Requests Sent',    $summary['requests_sent'] ?? 0,    'bg-cyan-50 text-cyan-600',   '<path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>'],
    ];
    ?>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        <?php foreach ($cards as [$label, $value, $iconClass, $iconPath]): ?>
        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm flex flex-col items-center text-center gap-2 hover:shadow-md transition-shadow">
            <div class="h-10 w-10 rounded-full <?= $iconClass ?> flex items-center justify-center">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><?= $iconPath ?></svg>
            </div>
            <p class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($value) ?></p>
            <p class="text-xs text-gray-500 leading-tight"><?= htmlspecialchars($label) ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Recent Listings -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-gray-900">Recent Listings</h2>
                <p class="text-xs text-gray-500 mt-0.5">Your most recently listed items</p>
            </div>
            <a href="/browse" class="text-sm font-semibold text-brand-500 hover:text-brand-700">See all →</a>
        </div>

        <?php if (empty($recentItems)): ?>
        <div class="p-12 text-center">
            <div class="text-4xl mb-3">📦</div>
            <p class="text-sm font-semibold text-gray-600">No listings yet</p>
            <p class="text-xs text-gray-400 mt-1">Add your first item to start selling</p>
            <a href="/items/add" class="inline-flex items-center gap-2 mt-4 bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                + Add First Listing
            </a>
        </div>
        <?php else: ?>
        <div class="p-5 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            <?php foreach (array_slice($recentItems, 0, 10) as $item): ?>
            <article class="group border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition-all duration-200 hover:-translate-y-1 flex flex-col">
                <div class="h-40 bg-gray-100 overflow-hidden">
                    <?php if (!empty($item['image'])): ?>
                    <img src="/uploads/items/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200" />
                    <?php else: ?>
                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 gap-2">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-xs">No Image</span>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="p-3 flex flex-col gap-1 flex-1">
                    <h3 class="text-xs font-semibold text-gray-800 line-clamp-2 leading-snug"><?= htmlspecialchars($item['title']) ?></h3>
                    <p class="text-sm font-bold text-gray-900">₹<?= number_format((float)$item['price'], 0) ?></p>
                    <p class="text-xs text-gray-400 flex items-center gap-1">
                        <svg class="h-3 w-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <?= htmlspecialchars($item['city']) ?>
                    </p>
                    <a href="/items/view/<?= $item['id'] ?>" class="mt-auto block text-center bg-brand-500 hover:bg-brand-600 text-white text-xs font-semibold py-1.5 rounded-lg transition-colors mt-1">
                        View
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

</main>

<?php require __DIR__ . '/../dashboard/footer.php'; ?>
