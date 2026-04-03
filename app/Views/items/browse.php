<?php require __DIR__ . '/../dashboard/header.php'; ?>

<main class="px-4 sm:px-6 lg:px-8 py-6 space-y-5">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-gray-500">
        <a href="/dashboard" class="hover:text-brand-500">Home</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">Browse Items</span>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
        <h1 class="text-lg font-bold text-gray-900 mb-1">Browse Listings</h1>
        <p class="text-xs text-gray-500 mb-4">Find quality second-hand products from verified local sellers</p>

        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[160px]">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Search</label>
                <div class="flex border border-gray-300 rounded-lg overflow-hidden hover:border-brand-400 transition-colors">
                    <input type="text" name="search" value="<?= htmlspecialchars($filters['search'] ?? '') ?>"
                        placeholder="Phone, chair, books..." class="flex-1 px-3 py-2 text-sm border-none focus:outline-none focus:ring-0 bg-white" />
                    <button type="submit" class="px-3 bg-gray-50 border-l border-gray-300 text-gray-400 hover:text-brand-500 transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>
            </div>
            <div class="min-w-[130px]">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">City</label>
                <input type="text" name="city" value="<?= htmlspecialchars($filters['city'] ?? '') ?>"
                    placeholder="Any city" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg hover:border-brand-400 focus:border-brand-500 focus:ring-0 transition-colors" />
            </div>
            <div class="min-w-[120px]">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Type</label>
                <select name="mode" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg hover:border-brand-400 focus:border-brand-500 focus:ring-0 transition-colors bg-white">
                    <option value="">All Types</option>
                    <option value="sell" <?= ($filters['mode']??'')==='sell'?'selected':'' ?>>For Sale</option>
                    <option value="rent" <?= ($filters['mode']??'')==='rent'?'selected':'' ?>>For Rent</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-5 py-2 rounded-lg transition-colors shadow-sm">
                    Apply
                </button>
                <a href="/browse" class="border border-gray-300 text-gray-600 hover:bg-gray-50 text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Results -->
    <?php if (empty($items)): ?>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-16 text-center">
        <div class="text-5xl mb-4">🔍</div>
        <h3 class="text-base font-semibold text-gray-700">No items found</h3>
        <p class="text-sm text-gray-400 mt-1">Try adjusting your filters or search keywords</p>
        <a href="/browse" class="inline-flex items-center gap-2 mt-4 text-brand-500 hover:text-brand-700 text-sm font-semibold">Clear all filters →</a>
    </div>
    <?php else: ?>
    <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500"><?= count($items) ?> listing<?= count($items) !== 1 ? 's' : '' ?> found</p>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        <?php foreach ($items as $listing): ?>
        <article class="group bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-200 hover:-translate-y-1 flex flex-col shadow-sm">
            <div class="h-44 bg-gray-100 overflow-hidden relative">
                <?php if (!empty($listing['image'])): ?>
                <img src="/uploads/items/<?= htmlspecialchars($listing['image']) ?>" alt="<?= htmlspecialchars($listing['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                <?php else: ?>
                <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 gap-2">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="text-xs">No Image</span>
                </div>
                <?php endif; ?>
                <?php if (!empty($listing['mode'])): ?>
                <span class="absolute top-2 right-2 text-xs font-semibold px-2 py-0.5 rounded-full <?= $listing['mode']==='rent'?'bg-blue-100 text-blue-700':'bg-green-100 text-green-700' ?>">
                    <?= ucfirst($listing['mode']) ?>
                </span>
                <?php endif; ?>
            </div>
            <div class="p-3 flex flex-col gap-1.5 flex-1">
                <h3 class="text-sm font-semibold text-gray-800 line-clamp-2 leading-snug"><?= htmlspecialchars($listing['title']) ?></h3>
                <p class="text-base font-bold text-gray-900">₹<?= number_format((float)$listing['price'], 0) ?></p>
                <p class="text-xs text-gray-500 flex items-center gap-1">
                    <svg class="h-3 w-3 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <?= htmlspecialchars($listing['city']) ?>
                </p>
                <a href="/items/view/<?= $listing['id'] ?>" class="mt-auto block text-center text-xs font-bold py-2 px-3 rounded-lg bg-brand-500 hover:bg-brand-600 text-white transition-colors mt-1">
                    View Details
                </a>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</main>

<?php require __DIR__ . '/../dashboard/footer.php'; ?>
