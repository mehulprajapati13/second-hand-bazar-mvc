<?php require __DIR__ . '/../dashboard/header.php'; ?>

<main class="px-4 sm:px-6 lg:px-8 py-6 space-y-5">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-gray-500">
        <a href="/dashboard" class="hover:text-brand-500">Home</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">My Listings</span>
    </div>

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl font-bold text-gray-900">My Listings</h1>
            <p class="text-sm text-gray-500 mt-0.5">Manage, edit, or remove your posted items</p>
        </div>
        <a href="/items/add" class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors shadow-sm self-start sm:self-auto">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Add New Item
        </a>
    </div>

    <!-- Alerts -->
    <?php if (!empty($message)): ?>
    <div class="bg-green-50 border border-green-200 rounded-xl px-4 py-3 flex items-center gap-3 text-sm text-green-700">
        <svg class="h-5 w-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <?= htmlspecialchars($message) ?>
    </div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'cannot_edit'): ?>
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl px-4 py-3 flex items-center gap-3 text-sm text-yellow-700">
        <svg class="h-5 w-5 text-yellow-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        This item cannot be edited because it has pending or approved requests.
    </div>
    <?php endif; ?>

    <!-- Items Grid -->
    <?php if (empty($items)): ?>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-16 text-center">
        <div class="text-5xl mb-4">📦</div>
        <h3 class="text-base font-semibold text-gray-700">No listings yet</h3>
        <p class="text-sm text-gray-400 mt-1">Start selling by adding your first item</p>
        <a href="/items/add" class="inline-flex items-center gap-2 mt-5 bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-6 py-2.5 rounded-lg transition-colors shadow-sm">
            + Add First Listing
        </a>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <?php foreach ($items as $item):
            $statusClr = [
                'active'   => 'bg-green-100 text-green-700',
                'sold'     => 'bg-gray-100 text-gray-600',
                'reserved' => 'bg-yellow-100 text-yellow-700',
            ];
            $sc = $statusClr[strtolower($item['status']??'')] ?? 'bg-gray-100 text-gray-600';
        ?>
        <article class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col">
            <!-- Image -->
            <div class="h-44 bg-gray-100 overflow-hidden relative">
                <?php if (!empty($item['image'])): ?>
                <img src="/uploads/items/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="w-full h-full object-cover" />
                <?php else: ?>
                <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 gap-2">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="text-xs">No Image</span>
                </div>
                <?php endif; ?>
                <span class="absolute top-2 left-2 text-xs font-semibold px-2.5 py-0.5 rounded-full <?= $sc ?>">
                    <?= ucfirst($item['status'] ?? 'active') ?>
                </span>
            </div>

            <!-- Info -->
            <div class="p-4 flex flex-col gap-2 flex-1">
                <h3 class="text-sm font-semibold text-gray-800 line-clamp-2 leading-snug"><?= htmlspecialchars($item['title']) ?></h3>
                <div class="flex items-center justify-between">
                    <p class="text-base font-bold text-gray-900">₹<?= number_format((float)$item['price'], 0) ?></p>
                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full"><?= ucfirst($item['mode'] ?? '') ?></span>
                </div>
                <p class="text-xs text-gray-400 flex items-center gap-1">
                    <svg class="h-3 w-3 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <?= htmlspecialchars($item['city']) ?>
                </p>

                <!-- Action Buttons -->
                <div class="mt-auto pt-2 grid grid-cols-3 gap-2">
                    <a href="/items/view/<?= $item['id'] ?>" class="flex items-center justify-center gap-1 bg-brand-500 hover:bg-brand-600 text-white text-xs font-semibold py-2 rounded-lg transition-colors">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        View
                    </a>
                    <a href="/items/edit/<?= $item['id'] ?>" class="flex items-center justify-center gap-1 border border-gray-300 text-gray-600 hover:border-brand-400 hover:text-brand-600 text-xs font-semibold py-2 rounded-lg transition-colors">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                    </a>
                    <form action="/items/delete/<?= $item['id'] ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                        <button type="submit" class="w-full flex items-center justify-center gap-1 border border-red-200 text-red-500 hover:bg-red-50 hover:border-red-400 text-xs font-semibold py-2 rounded-lg transition-colors">
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</main>

<?php require __DIR__ . '/../dashboard/footer.php'; ?>
