<?php require __DIR__ . '/../dashboard/header.php'; ?>

<main class="px-4 sm:px-6 lg:px-8 py-6 space-y-6">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-gray-500">
        <a href="/dashboard" class="hover:text-brand-500">Home</a>
        <span>/</span>
        <a href="/browse" class="hover:text-brand-500">Browse</a>
        <span>/</span>
        <span class="text-gray-700 font-medium truncate max-w-[150px]"><?= htmlspecialchars($item['title']) ?></span>
    </div>

    <!-- Success / Error Messages -->
    <?php if (isset($_GET['success']) && $_GET['success'] === 'request_sent'): ?>
        <div class="bg-green-50 border border-green-200 rounded-xl p-4">
            <p class="text-green-700 text-sm font-semibold">✓ Request sent successfully! Wait for the owner to respond.</p>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <?php $errMap = ['already_sent' => 'You already sent a request for this item.', 'unavailable' => 'This item is no longer available.']; ?>
        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <p class="text-red-700 text-sm font-semibold"><?= htmlspecialchars($errMap[$_GET['error']] ?? 'Something went wrong.') ?></p>
        </div>
    <?php endif; ?>

    <!-- Product Detail Card -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <!-- Image -->
            <div class="bg-gray-100 flex items-center justify-center min-h-[320px] lg:min-h-[420px] overflow-hidden">
                <?php if (!empty($item['image'])): ?>
                <img src="/uploads/items/<?= htmlspecialchars($item['image']) ?>"
                     alt="<?= htmlspecialchars($item['title']) ?>"
                     class="w-full h-full object-cover" />
                <?php else: ?>
                <div class="flex flex-col items-center justify-center text-gray-300 gap-3 p-16">
                    <svg class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-sm text-gray-400">No image available</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Info -->
            <div class="p-6 lg:p-8 flex flex-col gap-5">
                <!-- Status + Mode Badges -->
                <div class="flex items-center gap-2 flex-wrap">
                    <?php
                    $statusClr = ['active'=>'bg-green-100 text-green-700','sold'=>'bg-gray-100 text-gray-600','reserved'=>'bg-yellow-100 text-yellow-700','returned'=>'bg-blue-100 text-blue-700'];
                    $sc = $statusClr[strtolower($item['status'] ?? '')] ?? 'bg-gray-100 text-gray-600';
                    ?>
                    <span class="text-xs font-bold px-3 py-1 rounded-full <?= $sc ?>">
                        <?= ucfirst($item['status'] ?? 'active') ?>
                    </span>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full <?= ($item['mode']==='rent')?'bg-blue-100 text-blue-700':'bg-emerald-100 text-emerald-700' ?>">
                        For <?= ucfirst($item['mode'] ?? 'Sale') ?>
                    </span>
                </div>

                <!-- Title & Price -->
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 leading-snug">
                        <?= htmlspecialchars($item['title']) ?>
                    </h1>
                    <p class="text-3xl font-bold text-gray-900 mt-3">
                        ₹<?= number_format((float)$item['price'], 0) ?>
                        <?php if ($item['mode'] === 'rent'): ?>
                            <span class="text-sm font-normal text-gray-400">/ day</span>
                        <?php endif; ?>
                    </p>
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400">Location</p>
                        <p class="text-sm font-semibold text-gray-800 mt-0.5"><?= htmlspecialchars($item['city']) ?></p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400">Seller</p>
                        <p class="text-sm font-semibold text-gray-800 mt-0.5"><?= htmlspecialchars($item['seller_name']) ?></p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3 col-span-2">
                        <p class="text-xs text-gray-400">Listed on</p>
                        <p class="text-sm font-semibold text-gray-800 mt-0.5"><?= date('d M Y', strtotime($item['created_at'])) ?></p>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Description</p>
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                        <?= htmlspecialchars($item['description']) ?>
                    </p>
                </div>

                <!-- Action Area -->
                <div class="pt-1">
                    <?php
                    $isOwner   = isset($similarItems) ? false : false; // set below
                    $userId    = $_SESSION['user']['id'];
                    $isOwner   = (int)$item['user_id'] === (int)$userId;
                    $isActive  = strtolower($item['status'] ?? '') === 'active';
                    ?>

                    <?php if ($isOwner): ?>
                        <!-- Owner sees edit link -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">
                            <p class="text-blue-700 text-sm font-medium mb-2">This is your listing.</p>
                            <a href="/items/edit/<?= $item['id'] ?>"
                               class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold px-5 py-2 rounded-lg transition-colors">
                                Edit Item
                            </a>
                        </div>

                    <?php elseif (!$isActive): ?>
                        <!-- Item not available -->
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-center">
                            <p class="text-gray-500 text-sm">This item is no longer available.</p>
                        </div>

                    <?php elseif (!empty($alreadySent)): ?>
                        <!-- Already sent request -->
                        <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
                            <p class="text-green-700 text-sm font-semibold mb-1">✓ Request already sent.</p>
                            <p class="text-green-600 text-xs mb-3">Waiting for the owner to respond.</p>
                            <a href="/requests?tab=sent" class="text-brand-500 hover:text-brand-700 text-sm font-semibold">
                                View my requests →
                            </a>
                        </div>

                    <?php else: ?>
                        <!-- Send Request Form -->
                        <form action="/requests/send" method="POST">
                            <input type="hidden" name="item_id"  value="<?= $item['id'] ?>"/>
                            <input type="hidden" name="owner_id" value="<?= $item['user_id'] ?>"/>
                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-bold px-5 py-3 rounded-xl text-sm transition-colors shadow-sm">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                Send <?= $item['mode'] === 'rent' ? 'Rent' : 'Buy' ?> Request
                            </button>
                        </form>
                    <?php endif; ?>

                    <a href="/browse" class="mt-3 flex items-center justify-center gap-1 text-sm text-gray-500 hover:text-gray-700 transition-colors">
                        ← Back to Browse
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Similar Items -->
    <?php if (!empty($similarItems)): ?>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-base font-bold text-gray-900">Similar Items</h2>
            <a href="/browse" class="text-sm font-semibold text-brand-500 hover:text-brand-700">See all →</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php foreach (array_slice($similarItems, 0, 4) as $related): ?>
            <article class="group border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition-all duration-200 hover:-translate-y-1 flex flex-col">
                <div class="h-36 bg-gray-100 overflow-hidden">
                    <?php if (!empty($related['image'])): ?>
                    <img src="/uploads/items/<?= htmlspecialchars($related['image']) ?>"
                         alt="<?= htmlspecialchars($related['title']) ?>"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200" />
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="p-3 flex flex-col gap-1 flex-1">
                    <h3 class="text-xs font-semibold text-gray-800 line-clamp-2"><?= htmlspecialchars($related['title']) ?></h3>
                    <p class="text-sm font-bold text-gray-900">₹<?= number_format((float)$related['price'], 0) ?></p>
                    <p class="text-xs text-gray-400"><?= htmlspecialchars($related['city']) ?></p>
                    <a href="/items/view/<?= $related['id'] ?>"
                       class="mt-auto block text-center bg-brand-500 hover:bg-brand-600 text-white text-xs font-semibold py-1.5 rounded-lg transition-colors mt-1">
                        View
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

</main>

<?php require __DIR__ . '/../dashboard/footer.php'; ?>
