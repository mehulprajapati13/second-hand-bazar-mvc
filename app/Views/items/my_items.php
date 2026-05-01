<?php
$pageTitle = 'My Listings';
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

                <!-- Page Header -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <div>
                        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight m-0 mb-1">My Listings</h1>
                        <p class="text-sm text-gray-500 font-medium m-0">Manage, edit, or remove your posted items</p>
                    </div>
                    <a href="/items/add" class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-bold px-5 py-2.5 rounded-xl transition-all shadow-sm shadow-orange-500/20 hover:-translate-y-0.5 no-underline shrink-0">
                        <i class="bi bi-plus-lg"></i> Add New Item
                    </a>
                </div>

                <!-- Alerts -->
                <?php if (!empty($message)): ?>
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3 shadow-sm font-semibold text-sm">
                    <i class="bi bi-check-circle-fill text-lg"></i>
                    <span><?= htmlspecialchars($message) ?></span>
                </div>
                <?php endif; ?>

                <?php if (isset($_GET['error']) && $_GET['error'] === 'cannot_edit'): ?>
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3 shadow-sm font-semibold text-sm">
                    <i class="bi bi-exclamation-triangle-fill text-lg"></i>
                    <span>This item cannot be edited because it has pending or approved requests.</span>
                </div>
                <?php endif; ?>

                <!-- Items Grid -->
                <?php if (empty($items)): ?>
                <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-12 text-center shadow-sm">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                        <i class="bi bi-box-seam text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No listings yet</h3>
                    <p class="text-gray-500 max-w-sm mx-auto mb-6">Start selling by adding your first item to the marketplace.</p>
                    <a href="/items/add" class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold px-6 py-2.5 rounded-xl transition-colors shadow-sm no-underline">
                        <i class="bi bi-plus-lg"></i> Add First Listing
                    </a>
                </div>
                <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    <?php foreach ($items as $i => $item):
                        $statusColors = [
                            'active'   => 'bg-emerald-500',
                            'sold'     => 'bg-gray-500',
                            'reserved' => 'bg-amber-500',
                        ];
                        $badgeColor = $statusColors[strtolower($item['status'] ?? '')] ?? 'bg-gray-500';
                    ?>
                    <article class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-full animate-[fadeInUp_0.4s_ease-out_both]" style="animation-delay: <?= $i * 0.05 ?>s;">
                        
                        <!-- Image Box -->
                        <div class="relative pt-[75%] bg-gray-100 overflow-hidden group">
                            <?php if (!empty($item['image'])): ?>
                                <img src="/uploads/items/<?= htmlspecialchars(getRealImage($item['image'])) ?>"
                                     alt="<?= htmlspecialchars($item['title']) ?>" loading="lazy" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                            <?php else: ?>
                                <div class="absolute inset-0 flex items-center justify-center text-gray-300">
                                    <i class="bi bi-image text-4xl"></i>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Badges -->
                            <div class="absolute top-3 left-3 flex flex-col gap-2">
                                <span class="<?= $badgeColor ?>/90 backdrop-blur text-white text-[10px] font-extrabold uppercase tracking-wider px-3 py-1.5 rounded-lg shadow-sm">
                                    <?= ucfirst($item['status'] ?? 'active') ?>
                                </span>
                            </div>
                            <?php if (!empty($item['mode'])): ?>
                                <div class="absolute top-3 right-3">
                                    <span class="bg-white/90 text-gray-700 backdrop-blur text-[10px] font-extrabold uppercase tracking-wider px-3 py-1.5 rounded-lg shadow-sm">
                                        <?= ucfirst($item['mode']) ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Info -->
                        <div class="p-5 flex flex-col flex-grow">
                            <h6 class="font-bold text-gray-900 text-base mb-1 truncate"><?= htmlspecialchars($item['title']) ?></h6>
                            <div class="font-extrabold text-xl text-orange-500 mb-4">₹<?= number_format((float)$item['price'], 0) ?></div>
                            
                            <div class="flex items-center text-gray-500 text-xs font-semibold mb-4">
                                <i class="bi bi-geo-alt-fill text-gray-400 mr-1.5"></i><?= htmlspecialchars($item['city']) ?>
                            </div>

                            <!-- Actions -->
                            <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between gap-2">
                                <a href="/items/view/<?= $item['id'] ?>" class="flex-1 text-center bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-bold py-2 rounded-lg transition-colors no-underline">
                                    <i class="bi bi-eye mr-1"></i> View
                                </a>
                                <a href="/items/edit/<?= $item['id'] ?>" class="flex-1 text-center bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold py-2 rounded-lg transition-colors no-underline">
                                    <i class="bi bi-pencil mr-1"></i> Edit
                                </a>
                                <form action="/items/delete/<?= $item['id'] ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');" class="flex-1 m-0">
                                    <button type="submit" class="w-full text-center bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold py-2 rounded-lg transition-colors border-none cursor-pointer">
                                        <i class="bi bi-trash mr-1"></i> Del
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
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
