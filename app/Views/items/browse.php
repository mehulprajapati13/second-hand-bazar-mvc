<?php
$pageTitle = 'Browse Items';
require __DIR__ . '/../includes/head.php';
require __DIR__ . '/../includes/navigation.php';
?>

<div class="bg-gray-50/50 min-h-[calc(100vh-72px)] py-8 font-sans">
    <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
        
        <?php if (isset($_SESSION['user'])): ?>
        <div class="mb-6">
            <a href="/dashboard" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-orange-600 transition-colors no-underline bg-white px-4 py-2 rounded-xl border border-gray-200 shadow-sm hover:shadow-md">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>
        <?php endif; ?>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight m-0 mb-1">Explore Marketplace</h1>
                <p class="text-gray-500 font-medium m-0">Discover thousands of verified second-hand items</p>
            </div>
            <div class="text-sm font-medium text-gray-500 bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm">
                <span class="font-extrabold text-orange-500 text-lg"><?= count($items) ?></span> listings found
            </div>
        </div>

        <div class="row g-6">
            <!-- Left Sidebar (Filters) -->
            <div class="col-lg-3">
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm sticky top-24">
                    <h6 class="font-extrabold text-gray-900 text-lg mb-6 flex items-center gap-2">
                        <i class="bi bi-funnel-fill text-orange-500"></i> Filters
                    </h6>
                    
                    <form method="GET" action="/browse">
                        
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Keywords</label>
                            <div class="relative">
                                <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="search" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors shadow-sm text-sm outline-none" placeholder="e.g. iPhone, Sofa" value="<?= htmlspecialchars($filters['search'] ?? '') ?>" />
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Location</label>
                            <div class="relative">
                                <i class="bi bi-geo-alt absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="city" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors shadow-sm text-sm outline-none" placeholder="City name" value="<?= htmlspecialchars($filters['city'] ?? '') ?>" />
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Listing Type</label>
                            <div class="flex flex-col gap-3">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <div class="relative flex items-center justify-center w-5 h-5">
                                        <input type="radio" name="mode" value="" class="peer appearance-none w-5 h-5 border-2 border-gray-300 rounded-full checked:border-orange-500 checked:bg-orange-50 transition-colors cursor-pointer" <?= empty($filters['mode']) ? 'checked' : '' ?>>
                                        <div class="absolute w-2.5 h-2.5 bg-orange-500 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">All Items</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <div class="relative flex items-center justify-center w-5 h-5">
                                        <input type="radio" name="mode" value="sell" class="peer appearance-none w-5 h-5 border-2 border-gray-300 rounded-full checked:border-orange-500 checked:bg-orange-50 transition-colors cursor-pointer" <?= ($filters['mode'] ?? '') === 'sell' ? 'checked' : '' ?>>
                                        <div class="absolute w-2.5 h-2.5 bg-orange-500 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">For Sale</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <div class="relative flex items-center justify-center w-5 h-5">
                                        <input type="radio" name="mode" value="rent" class="peer appearance-none w-5 h-5 border-2 border-gray-300 rounded-full checked:border-orange-500 checked:bg-orange-50 transition-colors cursor-pointer" <?= ($filters['mode'] ?? '') === 'rent' ? 'checked' : '' ?>>
                                        <div class="absolute w-2.5 h-2.5 bg-orange-500 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">For Rent</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 pt-2">
                            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold px-4 py-3 rounded-xl transition-all shadow-sm shadow-orange-500/20 hover:-translate-y-0.5 border-none cursor-pointer">
                                Apply Filters
                            </button>
                            <?php if (!empty($filters['search']) || !empty($filters['city']) || !empty($filters['mode'])): ?>
                                <a href="/browse" class="w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold px-4 py-3 rounded-xl transition-colors no-underline">
                                    Clear All
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Content (Product Grid) -->
            <div class="col-lg-9">
                <?php if (empty($items)): ?>
                    <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-12 text-center shadow-sm">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                            <i class="bi bi-search text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No results found</h3>
                        <p class="text-gray-500 max-w-sm mx-auto mb-6">We couldn't find any items matching your filters.</p>
                        <a href="/browse" class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold px-6 py-2.5 rounded-xl transition-colors shadow-sm no-underline">
                            Clear Filters
                        </a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        <?php foreach ($items as $i => $listing): ?>
                        <a href="/items/view/<?= $listing['id'] ?>" class="group no-underline block h-full animate-[fadeInUp_0.4s_ease-out_both]" style="animation-delay: <?= $i * 0.05 ?>s;">
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-orange-500/10 hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-full">
                                
                                <!-- Image Box -->
                                <div class="relative pt-[75%] bg-gray-100 overflow-hidden">
                                    <?php if (!empty($listing['image'])): ?>
                                        <img src="/uploads/items/<?= htmlspecialchars(getRealImage($listing['image'])) ?>" 
                                             alt="<?= htmlspecialchars($listing['title']) ?>" 
                                             loading="lazy" 
                                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                    <?php else: ?>
                                        <div class="absolute inset-0 flex items-center justify-center text-gray-300">
                                            <i class="bi bi-image text-4xl"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Mode Badge -->
                                    <?php if (!empty($listing['mode'])): ?>
                                        <div class="absolute top-3 left-3">
                                            <span class="<?= $listing['mode'] === 'rent' ? 'bg-blue-500/90 text-white' : 'bg-emerald-500/90 text-white' ?> backdrop-blur text-[10px] font-extrabold uppercase tracking-wider px-3 py-1.5 rounded-lg shadow-sm">
                                                <?= ucfirst($listing['mode']) ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Content -->
                                <div class="p-5 flex flex-col flex-grow">
                                    <h6 class="font-bold text-gray-900 text-base mb-1 truncate"><?= htmlspecialchars($listing['title']) ?></h6>
                                    <div class="font-extrabold text-xl text-orange-500 mb-4">₹<?= number_format((float)$listing['price'], 0) ?></div>
                                    
                                    <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between text-gray-500 text-xs font-semibold">
                                        <span class="flex items-center gap-1.5 truncate">
                                            <i class="bi bi-geo-alt-fill text-gray-400"></i><?= htmlspecialchars($listing['city']) ?>
                                        </span>
                                        <span class="shrink-0 text-gray-400"><?= date('d M Y', strtotime($listing['created_at'])) ?></span>
                                    </div>
                                </div>

                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
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
