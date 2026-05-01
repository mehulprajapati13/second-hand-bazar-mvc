<?php
$pageTitle = 'Requests';
require __DIR__ . '/../includes/head.php';
require __DIR__ . '/../includes/navigation.php';

// Status badge helper
function statusBadge(string $status): array
{
    return match ($status) {
        'pending'   => ['bg' => 'bg-amber-50', 'color' => 'text-amber-600', 'border' => 'border-amber-200', 'text' => 'Pending', 'icon' => 'bi-clock-history'],
        'approved'  => ['bg' => 'bg-emerald-50', 'color' => 'text-emerald-600', 'border' => 'border-emerald-200', 'text' => 'Approved', 'icon' => 'bi-check-circle-fill'],
        'rejected'  => ['bg' => 'bg-rose-50', 'color' => 'text-rose-600', 'border' => 'border-rose-200', 'text' => 'Rejected', 'icon' => 'bi-x-circle-fill'],
        'completed' => ['bg' => 'bg-blue-50', 'color' => 'text-blue-600', 'border' => 'border-blue-200', 'text' => 'Completed', 'icon' => 'bi-check2-all'],
        'cancelled' => ['bg' => 'bg-gray-100', 'color' => 'text-gray-600', 'border' => 'border-gray-200', 'text' => 'Cancelled', 'icon' => 'bi-dash-circle-fill'],
        default     => ['bg' => 'bg-gray-100', 'color' => 'text-gray-600', 'border' => 'border-gray-200', 'text' => ucfirst($status), 'icon' => 'bi-circle-fill'],
    };
}
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
                    <span class="text-gray-900">Requests</span>
                </div>

                <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight m-0 mb-1">Requests</h1>
                        <p class="text-gray-500 font-medium m-0">Manage your incoming and outgoing buy/rent requests</p>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="flex gap-4 border-b border-gray-200 mb-6">
                    <a href="/requests?tab=received" class="relative px-4 py-3 font-bold text-sm transition-colors no-underline flex items-center gap-2 <?= $tab === 'received' ? 'text-orange-600 border-b-2 border-orange-500' : 'text-gray-500 hover:text-gray-700' ?>">
                        <i class="bi bi-inbox-fill text-lg"></i> Received
                        <?php $pendingCount = count(array_filter($received, fn($r) => $r['status'] === 'pending')); ?>
                        <?php if ($pendingCount > 0): ?>
                            <span class="bg-orange-500 text-white text-[10px] px-2 py-0.5 rounded-full"><?= $pendingCount ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="/requests?tab=sent" class="relative px-4 py-3 font-bold text-sm transition-colors no-underline flex items-center gap-2 <?= $tab === 'sent' ? 'text-orange-600 border-b-2 border-orange-500' : 'text-gray-500 hover:text-gray-700' ?>">
                        <i class="bi bi-send-fill text-lg"></i> Sent
                    </a>
                </div>

                <!-- ═══════════════ RECEIVED TAB ═══════════════ -->
                <?php if ($tab === 'received'): ?>

                    <?php if (empty($received)): ?>
                        <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-12 text-center shadow-sm">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                <i class="bi bi-inbox text-4xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">No requests received yet</h3>
                            <p class="text-gray-500 max-w-sm mx-auto mb-0">When buyers request your items, they will appear here.</p>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 gap-4">
                            <?php foreach ($received as $i => $req):
                                $badge = statusBadge($req['status']);
                            ?>
                                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow group animate-[fadeInUp_0.4s_ease-out_both]" style="animation-delay: <?= $i * 0.05 ?>s;">
                                    <div class="flex flex-col sm:flex-row gap-5">
                                        <!-- Item image -->
                                        <div class="w-full sm:w-32 h-32 rounded-xl bg-gray-100 overflow-hidden shrink-0 border border-gray-100">
                                            <?php if (!empty($req['item_image'])): ?>
                                                <img src="/uploads/items/<?= htmlspecialchars($req['item_image']) ?>" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                    <i class="bi bi-image text-3xl"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="flex-1 min-w-0 flex flex-col justify-between">
                                            <!-- Header row -->
                                            <div>
                                                <div class="flex flex-col md:flex-row md:items-start justify-between gap-3 mb-2">
                                                    <div>
                                                        <h4 class="text-lg font-bold text-gray-900 m-0 leading-tight">
                                                            <?= htmlspecialchars($req['item_title']) ?>
                                                            <span class="text-xs font-semibold text-orange-500 bg-orange-50 px-2 py-0.5 rounded-md ml-2 border border-orange-100 align-middle">
                                                                <?= ucfirst($req['item_mode']) ?>
                                                            </span>
                                                        </h4>
                                                        <div class="flex items-center gap-3 text-sm text-gray-500 mt-2 font-medium">
                                                            <span class="flex items-center gap-1"><i class="bi bi-person-circle text-gray-400"></i> <?= htmlspecialchars($req['requester_name']) ?></span>
                                                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                                            <span class="flex items-center gap-1"><i class="bi bi-calendar3 text-gray-400"></i> <?= date('d M Y', strtotime($req['created_at'])) ?></span>
                                                        </div>
                                                    </div>
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border <?= $badge['bg'] ?> <?= $badge['color'] ?> <?= $badge['border'] ?>">
                                                        <i class="bi <?= $badge['icon'] ?>"></i> <?= $badge['text'] ?>
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- APPROVED: Show buyer contact info -->
                                            <?php if ($req['status'] === 'approved'): ?>
                                                <div class="mt-4 bg-emerald-50 border border-emerald-100 rounded-xl p-4">
                                                    <div class="text-sm font-bold text-emerald-800 mb-3 flex items-center gap-2">
                                                        <i class="bi bi-check-circle-fill text-emerald-500"></i> Approved — Contact buyer to arrange handover
                                                    </div>
                                                    <div class="flex flex-wrap gap-3">
                                                        <?php if (!empty($req['requester_phone'])): ?>
                                                            <a href="tel:<?= htmlspecialchars($req['requester_phone']) ?>" class="inline-flex items-center gap-2 bg-white border border-emerald-200 text-emerald-700 hover:bg-emerald-500 hover:text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors no-underline shadow-sm">
                                                                <i class="bi bi-telephone-fill"></i> <?= htmlspecialchars($req['requester_phone']) ?>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if (!empty($req['requester_email'])): ?>
                                                            <a href="mailto:<?= htmlspecialchars($req['requester_email']) ?>" class="inline-flex items-center gap-2 bg-white border border-blue-200 text-blue-600 hover:bg-blue-500 hover:text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors no-underline shadow-sm">
                                                                <i class="bi bi-envelope-fill"></i> Email Buyer
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Action buttons -->
                                            <?php if ($req['status'] === 'pending'): ?>
                                                <div class="flex flex-wrap gap-3 mt-4 pt-4 border-t border-gray-100">
                                                    <form action="/requests/approve/<?= $req['id'] ?>" method="POST" class="m-0">
                                                        <button type="submit" class="flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2 rounded-lg font-semibold text-sm transition-colors shadow-sm">
                                                            <i class="bi bi-check-lg"></i> Accept Request
                                                        </button>
                                                    </form>
                                                    <form action="/requests/reject/<?= $req['id'] ?>" method="POST" class="m-0">
                                                        <button type="submit" class="flex items-center gap-2 bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 px-5 py-2 rounded-lg font-semibold text-sm transition-colors shadow-sm">
                                                            <i class="bi bi-x-lg"></i> Decline
                                                        </button>
                                                    </form>
                                                </div>

                                            <?php elseif ($req['status'] === 'approved'): ?>
                                                <div class="mt-4 pt-4 border-t border-gray-100">
                                                    <?php if ($req['item_mode'] === 'sell'): ?>
                                                        <form action="/requests/sold/<?= $req['id'] ?>" method="POST" onsubmit="return confirm('Mark as sold after physical handover?')" class="m-0">
                                                            <button type="submit" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold text-sm transition-colors shadow-sm">
                                                                <i class="bi bi-bag-check-fill"></i> Mark as Sold
                                                            </button>
                                                        </form>
                                                    <?php else: ?>
                                                        <form action="/requests/returned/<?= $req['id'] ?>" method="POST" onsubmit="return confirm('Mark item as returned?')" class="m-0">
                                                            <button type="submit" class="flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-lg font-semibold text-sm transition-colors shadow-sm">
                                                                <i class="bi bi-arrow-return-left font-bold"></i> Mark as Returned
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                <?php endif; ?>

                <!-- ═══════════════ SENT TAB ═══════════════ -->
                <?php if ($tab === 'sent'): ?>

                    <?php if (empty($sent)): ?>
                        <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-12 text-center shadow-sm">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                <i class="bi bi-send text-4xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">No requests sent yet</h3>
                            <p class="text-gray-500 max-w-sm mx-auto mb-6">Browse items and send a request to get started.</p>
                            <a href="/browse" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2.5 rounded-full transition-colors shadow-sm shadow-orange-500/20 no-underline">
                                <i class="bi bi-search"></i> Browse Items
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 gap-4">
                            <?php foreach ($sent as $i => $req):
                                $badge = statusBadge($req['status']);
                            ?>
                                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow group animate-[fadeInUp_0.4s_ease-out_both]" style="animation-delay: <?= $i * 0.05 ?>s;">
                                    <div class="flex flex-col sm:flex-row gap-5">
                                        <!-- Item image -->
                                        <div class="w-full sm:w-32 h-32 rounded-xl bg-gray-100 overflow-hidden shrink-0 border border-gray-100">
                                            <?php if (!empty($req['item_image'])): ?>
                                                <img src="/uploads/items/<?= htmlspecialchars($req['item_image']) ?>" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                    <i class="bi bi-image text-3xl"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="flex-1 min-w-0 flex flex-col justify-between">
                                            <!-- Header row -->
                                            <div>
                                                <div class="flex flex-col md:flex-row md:items-start justify-between gap-3 mb-2">
                                                    <div>
                                                        <h4 class="text-lg font-bold text-gray-900 m-0 leading-tight">
                                                            <?= htmlspecialchars($req['item_title']) ?>
                                                            <span class="text-sm font-extrabold text-orange-600 ml-2">
                                                                ₹<?= number_format((float)($req['item_price'] ?? 0), 0) ?>
                                                            </span>
                                                        </h4>
                                                        <div class="flex items-center gap-3 text-sm text-gray-500 mt-2 font-medium">
                                                            <span class="flex items-center gap-1"><i class="bi bi-shop text-gray-400"></i> Seller: <span class="text-gray-700 font-semibold"><?= htmlspecialchars($req['owner_name']) ?></span></span>
                                                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                                            <span class="flex items-center gap-1"><i class="bi bi-calendar3 text-gray-400"></i> <?= date('d M Y', strtotime($req['created_at'])) ?></span>
                                                        </div>
                                                    </div>
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border <?= $badge['bg'] ?> <?= $badge['color'] ?> <?= $badge['border'] ?>">
                                                        <i class="bi <?= $badge['icon'] ?>"></i> <?= $badge['text'] ?>
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- APPROVED: Show seller contact info -->
                                            <?php if ($req['status'] === 'approved'): ?>
                                                <div class="mt-4 bg-emerald-50 border border-emerald-100 rounded-xl p-4">
                                                    <div class="text-sm font-bold text-emerald-800 mb-3 flex items-center gap-2">
                                                        <i class="bi bi-check-circle-fill text-emerald-500"></i> Request approved! Contact the seller to arrange handover
                                                    </div>
                                                    <div class="flex flex-wrap gap-3">
                                                        <?php if (!empty($req['owner_phone'])): ?>
                                                            <a href="tel:<?= htmlspecialchars($req['owner_phone']) ?>" class="inline-flex items-center gap-2 bg-white border border-emerald-200 text-emerald-700 hover:bg-emerald-500 hover:text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors no-underline shadow-sm">
                                                                <i class="bi bi-telephone-fill"></i> <?= htmlspecialchars($req['owner_phone']) ?>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if (!empty($req['owner_email'])): ?>
                                                            <a href="mailto:<?= htmlspecialchars($req['owner_email']) ?>" class="inline-flex items-center gap-2 bg-white border border-blue-200 text-blue-600 hover:bg-blue-500 hover:text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors no-underline shadow-sm">
                                                                <i class="bi bi-envelope-fill"></i> Email Seller
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if (!empty($req['owner_city'])): ?>
                                                            <span class="inline-flex items-center gap-1.5 bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold shadow-sm">
                                                                <i class="bi bi-geo-alt-fill text-gray-400"></i> <?= htmlspecialchars($req['owner_city']) ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($req['status'] === 'rejected'): ?>
                                                <div class="mt-4 bg-rose-50 border border-rose-200 rounded-xl p-4 flex items-center gap-2 text-rose-700 text-sm font-medium">
                                                    <i class="bi bi-x-circle-fill"></i>
                                                    <span>Request was rejected. You can browse other similar items.</span>
                                                    <a href="/browse" class="font-bold text-rose-800 hover:underline ml-1">Browse →</a>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Cancel button for pending requests -->
                                            <?php if ($req['status'] === 'pending'): ?>
                                                <div class="mt-4 pt-4 border-t border-gray-100">
                                                    <form action="/requests/cancel/<?= $req['id'] ?>" method="POST" onsubmit="return confirm('Cancel this request?')" class="m-0">
                                                        <button type="submit" class="flex items-center gap-2 bg-white border border-gray-200 text-gray-600 hover:bg-gray-100 hover:text-gray-900 px-5 py-2 rounded-lg font-semibold text-sm transition-colors shadow-sm">
                                                            <i class="bi bi-x-lg font-bold"></i> Cancel Request
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

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