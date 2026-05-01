<?php
$pageTitle = $item['title'] ?? 'Item Details';
require __DIR__ . '/../includes/head.php';
require __DIR__ . '/../includes/navigation.php';

$itemId      = (int)($item['id']          ?? 0);
$title       = (string)($item['title']    ?? 'Untitled item');
$image       = $item['image']             ?? null;
$status      = strtolower((string)($item['status']      ?? 'active'));
$mode        = strtolower((string)($item['mode']        ?? 'sell'));
$price       = (float)($item['price']     ?? 0);
$city        = (string)($item['city']     ?? 'Unknown');
$sellerName  = (string)($item['seller_name']  ?? 'Seller');
$sellerPhone = (string)($item['seller_phone'] ?? '');
$sellerEmail = (string)($item['seller_email'] ?? '');
$description = (string)($item['description'] ?? 'No description provided.');
$listedOn    = !empty($item['created_at']) ? date('d M Y', strtotime($item['created_at'])) : 'N/A';

$isActive = $status === 'active';
?>

<div class="bg-gray-50/50 min-h-[calc(100vh-72px)] py-8 font-sans">
    <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
        <!-- Breadcrumb -->
        <nav class="flex text-sm text-gray-500 font-medium mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/" class="hover:text-orange-500 transition-colors no-underline text-gray-500 flex items-center"><i class="bi bi-house-door mr-2"></i>Home</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 text-xs mx-1"></i>
                        <a href="/browse" class="hover:text-orange-500 transition-colors no-underline text-gray-500 ml-1 md:ml-2">Marketplace</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 text-xs mx-1"></i>
                        <span class="text-gray-900 font-bold ml-1 md:ml-2 truncate max-w-[200px] md:max-w-md"><?= htmlspecialchars($title) ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Alerts -->
        <?php if (isset($_GET['success']) && $_GET['success'] === 'request_sent'): ?>
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-4 mb-6 flex items-start gap-3 shadow-sm">
                <i class="bi bi-check-circle-fill text-emerald-500 text-xl mt-0.5"></i>
                <div>
                    <h3 class="font-bold text-emerald-900 m-0">Request sent successfully!</h3>
                    <p class="text-emerald-700 text-sm mt-1 mb-0">The seller has been notified and will review your request.</p>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <?php $errMap = ['already_sent' => 'You already sent a request for this item.', 'unavailable' => 'This item is no longer available.']; ?>
            <div class="bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl p-4 mb-6 flex items-start gap-3 shadow-sm">
                <i class="bi bi-exclamation-triangle-fill text-rose-500 text-xl mt-0.5"></i>
                <div>
                    <h3 class="font-bold text-rose-900 m-0">Action failed</h3>
                    <p class="text-rose-700 text-sm mt-1 mb-0"><?= htmlspecialchars($errMap[$_GET['error']] ?? 'Something went wrong.') ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Product Layout -->
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Left Column: Gallery & Details -->
            <div class="w-full lg:w-2/3 flex flex-col gap-8">
                
                <!-- Main Image -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden relative">
                    <div class="relative pt-[75%] bg-gray-50 flex items-center justify-center">
                        <?php if (!empty($image)): ?>
                            <img src="/uploads/items/<?= htmlspecialchars((string)getRealImage($image)) ?>"
                                alt="<?= htmlspecialchars($title) ?>"
                                class="absolute inset-0 w-full h-full object-contain p-4" />
                        <?php else: ?>
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-300">
                                <i class="bi bi-image text-5xl mb-2"></i>
                                <span class="font-medium">No photo available</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Product Description Card -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 md:p-8">
                    <h3 class="text-xl font-extrabold text-gray-900 mb-4 pb-4 border-b border-gray-100">Description</h3>
                    <p class="text-gray-600 text-base leading-relaxed whitespace-pre-line mb-8">
                        <?= htmlspecialchars($description) ?>
                    </p>

                    <h3 class="text-xl font-extrabold text-gray-900 mb-4 pb-4 border-b border-gray-100">Location Details</h3>
                    <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-2xl">
                        <div class="w-10 h-10 bg-orange-100 text-orange-500 rounded-xl flex items-center justify-center shrink-0">
                            <i class="bi bi-geo-alt-fill text-xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 m-0">Item Location</p>
                            <p class="text-gray-500 text-sm m-0">This item is located in <strong class="text-gray-800"><?= htmlspecialchars($city) ?></strong>.</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Buy Box -->
            <div class="w-full lg:w-1/3">
                <div class="sticky top-24 flex flex-col gap-6">
                    
                    <!-- Price & Actions Card -->
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 md:p-8 relative overflow-hidden">
                        <!-- Decorative bg blob -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-bl-full -mr-8 -mt-8 pointer-events-none"></div>

                        <!-- Badges -->
                        <div class="flex flex-wrap gap-2 mb-4 relative z-10">
                            <span class="<?= $mode === 'rent' ? 'bg-blue-100 text-blue-700 border-blue-200' : 'bg-emerald-100 text-emerald-700 border-emerald-200' ?> border text-xs font-extrabold uppercase tracking-wider px-3 py-1.5 rounded-lg">
                                For <?= ucfirst($mode) ?>
                            </span>
                            <?php if ($status === 'reserved'): ?>
                                <span class="bg-amber-100 border border-amber-200 text-amber-800 text-xs font-extrabold uppercase tracking-wider px-3 py-1.5 rounded-lg">Reserved</span>
                            <?php elseif ($status === 'sold'): ?>
                                <span class="bg-gray-100 border border-gray-200 text-gray-600 text-xs font-extrabold uppercase tracking-wider px-3 py-1.5 rounded-lg">Sold</span>
                            <?php endif; ?>
                        </div>

                        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 leading-tight mb-4 relative z-10">
                            <?= htmlspecialchars($title) ?>
                        </h1>
                        
                        <div class="mb-6 relative z-10">
                            <div class="flex items-end gap-1">
                                <span class="text-4xl font-black text-orange-500">₹<?= number_format($price, 0) ?></span>
                                <?php if ($mode === 'rent'): ?>
                                    <span class="text-gray-400 font-bold mb-1">/ day</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-6 relative z-10">
                            <?php if ($isOwner): ?>
                                <div class="bg-orange-50 border border-orange-100 p-4 rounded-2xl text-center">
                                    <p class="font-bold text-orange-800 mb-3 text-sm">This is your listing</p>
                                    <a href="/items/edit/<?= $itemId ?>" class="flex items-center justify-center gap-2 bg-white text-orange-600 border border-orange-200 hover:bg-orange-600 hover:text-white font-bold py-3 px-4 rounded-xl transition-colors no-underline">
                                        <i class="bi bi-pencil"></i> Edit Details
                                    </a>
                                </div>
                            <?php elseif (!$isActive): ?>
                                <div class="bg-gray-100 text-gray-500 text-center font-bold py-4 rounded-xl flex items-center justify-center gap-2 cursor-not-allowed">
                                    <i class="bi bi-x-circle"></i> Unavailable
                                </div>
                            <?php elseif (!empty($alreadySent)): ?>
                                <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 text-center">
                                    <div class="w-12 h-12 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="bi bi-check-lg text-2xl"></i>
                                    </div>
                                    <strong class="block text-emerald-900 mb-1">Request Sent!</strong>
                                    <p class="text-emerald-700 text-sm mb-4">Waiting for seller response</p>
                                    <a href="/requests?tab=sent" class="inline-block bg-white text-emerald-600 border border-emerald-200 hover:bg-emerald-600 hover:text-white font-bold py-2 px-6 rounded-xl transition-colors text-sm no-underline">
                                        View Status
                                    </a>
                                </div>
                            <?php else: ?>
                                <form action="/requests/send" method="POST" class="m-0">
                                    <input type="hidden" name="item_id" value="<?= $itemId ?>" />
                                    <input type="hidden" name="owner_id" value="<?= $item['user_id'] ?>" />
                                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 px-6 rounded-xl transition-all shadow-sm shadow-orange-500/20 hover:-translate-y-1 border-none cursor-pointer text-lg">
                                        <i class="bi bi-lightning-charge-fill"></i> 
                                        Request to <?= $mode === 'rent' ? 'Rent' : 'Buy' ?>
                                    </button>
                                </form>
                                <div class="text-center mt-4 text-gray-400 text-xs font-semibold flex items-center justify-center gap-1.5">
                                    <i class="bi bi-shield-check text-orange-500"></i> Safe and secure transaction process
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Seller Info Card -->
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
                        <h6 class="font-extrabold text-xs uppercase tracking-wider text-gray-400 mb-4 m-0">Seller Information</h6>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-orange-100 to-orange-200 text-orange-600 rounded-2xl flex items-center justify-center text-xl font-black shadow-inner shrink-0">
                                <?= strtoupper(substr($sellerName, 0, 1)) ?>
                            </div>
                            <div>
                                <div class="font-extrabold text-gray-900 text-lg flex items-center gap-1.5">
                                    <?= htmlspecialchars($sellerName) ?>
                                    <i class="bi bi-patch-check-fill text-blue-500 text-sm" title="Verified Seller"></i>
                                </div>
                                <div class="text-gray-500 text-sm font-medium">Member since 2024</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-gray-500 text-sm font-medium bg-gray-50 p-3 rounded-xl m-0">
                            <i class="bi bi-calendar-check text-emerald-500"></i> Listed on <?= htmlspecialchars($listedOn) ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>