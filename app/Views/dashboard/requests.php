<?php require __DIR__ . '/../dashboard/header.php'; ?>

<main class="px-4 sm:px-6 lg:px-8 py-6 space-y-6">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-gray-500">
        <a href="/dashboard" class="hover:text-brand-500">Home</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">Requests</span>
    </div>

    <!-- Page Header -->
    <div>
        <h1 class="text-xl font-bold text-gray-900">Requests</h1>
        <p class="text-sm text-gray-500 mt-0.5">Manage incoming and outgoing purchase / rental requests</p>
    </div>

    <!-- Success Message -->
    <?php if (isset($_GET['msg'])): ?>
        <?php $msgMap = [
            'approved'  => ['text' => 'Request approved. Item is now reserved.', 'cls' => 'bg-green-50 border-green-200 text-green-700'],
            'rejected'  => ['text' => 'Request rejected.',                        'cls' => 'bg-red-50 border-red-200 text-red-700'],
            'sold'      => ['text' => 'Item marked as sold.',                     'cls' => 'bg-purple-50 border-purple-200 text-purple-700'],
            'returned'  => ['text' => 'Item returned and set back to active.',    'cls' => 'bg-blue-50 border-blue-200 text-blue-700'],
            'cancelled' => ['text' => 'Request cancelled.',                       'cls' => 'bg-gray-50 border-gray-200 text-gray-700'],
        ];
        $msg = $msgMap[$_GET['msg']] ?? null;
        ?>
        <?php if ($msg): ?>
        <div class="border rounded-xl p-4 <?= $msg['cls'] ?>">
            <p class="text-sm font-semibold"><?= $msg['text'] ?></p>
        </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Tabs -->
    <div class="flex gap-1 border-b border-gray-200">
        <?php
        $pendingCount = count(array_filter($incomingRequests, fn($r) => $r['status'] === 'pending'));
        ?>
        <a href="/requests?tab=received"
           class="px-5 py-2.5 text-sm font-semibold transition-colors border-b-2 -mb-px
                  <?= ($tab === 'received') ? 'border-brand-500 text-brand-600' : 'border-transparent text-gray-500 hover:text-gray-700' ?>">
            Received
            <?php if ($pendingCount > 0): ?>
                <span class="ml-1.5 bg-brand-500 text-white text-[10px] font-black px-1.5 py-0.5 rounded-full"><?= $pendingCount ?></span>
            <?php endif; ?>
        </a>
        <a href="/requests?tab=sent"
           class="px-5 py-2.5 text-sm font-semibold transition-colors border-b-2 -mb-px
                  <?= ($tab === 'sent') ? 'border-brand-500 text-brand-600' : 'border-transparent text-gray-500 hover:text-gray-700' ?>">
            Sent
        </a>
    </div>

    <!-- RECEIVED TAB -->
    <?php if ($tab === 'received'): ?>

        <?php if (empty($incomingRequests)): ?>
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-16 text-center">
            <div class="text-4xl mb-3">📭</div>
            <p class="text-sm font-semibold text-gray-600">No incoming requests yet</p>
            <p class="text-xs text-gray-400 mt-1">When buyers request your items, they'll appear here</p>
        </div>
        <?php else: ?>
        <div class="space-y-3">
            <?php foreach ($incomingRequests as $req):
                $st = strtolower($req['status'] ?? 'pending');
                $badgeMap = [
                    'pending'   => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                    'approved'  => 'bg-green-100 text-green-700 border-green-300',
                    'rejected'  => 'bg-red-100 text-red-600 border-red-300',
                    'completed' => 'bg-purple-100 text-purple-700 border-purple-300',
                    'cancelled' => 'bg-gray-100 text-gray-600 border-gray-300',
                ];
                $badgeCls = $badgeMap[$st] ?? 'bg-gray-100 text-gray-600 border-gray-300';
            ?>
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                <div class="flex items-start gap-4">
                    <!-- Item Thumbnail -->
                    <div class="h-14 w-14 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                        <?php if (!empty($req['item_image'])): ?>
                            <img src="/uploads/items/<?= htmlspecialchars($req['item_image']) ?>"
                                 class="w-full h-full object-cover"/>
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01"/></svg>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Info -->
                    <div class="flex-grow min-w-0">
                        <div class="flex items-start justify-between gap-4 flex-wrap">
                            <div>
                                <p class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($req['item_title']) ?></p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    Requested by <span class="font-semibold text-gray-700"><?= htmlspecialchars($req['requester_name'] ?? '—') ?></span>
                                    · <?= date('d M Y', strtotime($req['created_at'])) ?>
                                </p>
                            </div>
                            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full border <?= $badgeCls ?>">
                                <?= ucfirst($st) ?>
                            </span>
                        </div>

                        <!-- Action Buttons -->
                        <?php if ($st === 'pending'): ?>
                        <div class="flex gap-2 mt-3">
                            <form action="/requests/approve/<?= $req['id'] ?>" method="POST">
                                <button type="submit" class="inline-flex items-center gap-1.5 bg-green-50 hover:bg-green-100 border border-green-300 text-green-700 text-xs font-bold px-4 py-2 rounded-lg transition-all">
                                    ✓ Approve
                                </button>
                            </form>
                            <form action="/requests/reject/<?= $req['id'] ?>" method="POST">
                                <button type="submit" class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 border border-red-300 text-red-600 text-xs font-bold px-4 py-2 rounded-lg transition-all">
                                    ✗ Reject
                                </button>
                            </form>
                            <a href="/items/view/<?= $req['item_id'] ?>" class="inline-flex items-center gap-1 border border-gray-300 text-gray-500 hover:text-brand-500 text-xs font-semibold px-3 py-2 rounded-lg transition-all">
                                View Item
                            </a>
                        </div>

                        <?php elseif ($st === 'approved'): ?>
                        <div class="flex gap-2 mt-3 flex-wrap">
                            <?php if (($req['item_mode'] ?? 'sell') === 'sell'): ?>
                            <form action="/requests/sold/<?= $req['id'] ?>" method="POST"
                                  onsubmit="return confirm('Mark this item as sold after handover?')">
                                <button type="submit" class="inline-flex items-center gap-1.5 bg-purple-50 hover:bg-purple-100 border border-purple-300 text-purple-700 text-xs font-bold px-4 py-2 rounded-lg transition-all">
                                    Mark as Sold
                                </button>
                            </form>
                            <?php else: ?>
                            <form action="/requests/returned/<?= $req['id'] ?>" method="POST"
                                  onsubmit="return confirm('Mark item as returned?')">
                                <button type="submit" class="inline-flex items-center gap-1.5 bg-blue-50 hover:bg-blue-100 border border-blue-300 text-blue-700 text-xs font-bold px-4 py-2 rounded-lg transition-all">
                                    Mark as Returned
                                </button>
                            </form>
                            <?php endif; ?>
                            <div class="flex items-center gap-1.5 bg-green-50 border border-green-200 rounded-lg px-3 py-2">
                                <span class="text-xs text-green-700 font-medium">Approved — arrange handover with buyer</span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    <?php endif; ?>

    <!-- SENT TAB -->
    <?php if ($tab === 'sent'): ?>

        <?php if (empty($outgoingRequests)): ?>
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-16 text-center">
            <div class="text-4xl mb-3">📤</div>
            <p class="text-sm font-semibold text-gray-600">No outgoing requests yet</p>
            <p class="text-xs text-gray-400 mt-1">Browse items and send a request to get started</p>
            <a href="/browse" class="inline-flex items-center gap-2 mt-4 bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-5 py-2 rounded-lg transition-colors">
                Browse Items →
            </a>
        </div>
        <?php else: ?>
        <div class="space-y-3">
            <?php foreach ($outgoingRequests as $req):
                $st = strtolower($req['status'] ?? 'pending');
                $badgeMap = [
                    'pending'   => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                    'approved'  => 'bg-green-100 text-green-700 border-green-300',
                    'rejected'  => 'bg-red-100 text-red-600 border-red-300',
                    'completed' => 'bg-purple-100 text-purple-700 border-purple-300',
                    'cancelled' => 'bg-gray-100 text-gray-600 border-gray-300',
                ];
                $badgeCls = $badgeMap[$st] ?? 'bg-gray-100 text-gray-600 border-gray-300';
            ?>
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                <div class="flex items-start gap-4">
                    <!-- Item Thumbnail -->
                    <div class="h-14 w-14 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                        <?php if (!empty($req['item_image'])): ?>
                            <img src="/uploads/items/<?= htmlspecialchars($req['item_image']) ?>"
                                 class="w-full h-full object-cover"/>
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01"/></svg>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Info -->
                    <div class="flex-grow min-w-0">
                        <div class="flex items-start justify-between gap-4 flex-wrap">
                            <div>
                                <p class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($req['item_title']) ?></p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    Seller: <span class="font-semibold text-gray-700"><?= htmlspecialchars($req['owner_name'] ?? '—') ?></span>
                                    · <?= date('d M Y', strtotime($req['created_at'])) ?>
                                </p>
                            </div>
                            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full border <?= $badgeCls ?>">
                                <?= ucfirst($st) ?>
                            </span>
                        </div>

                        <!-- Approved message -->
                        <?php if ($st === 'approved'): ?>
                        <div class="mt-3 bg-green-50 border border-green-200 rounded-lg px-3 py-2">
                            <p class="text-xs text-green-700 font-medium">✓ Approved! Contact the seller to arrange handover.</p>
                        </div>
                        <?php endif; ?>

                        <!-- Cancel button — only for pending -->
                        <?php if ($st === 'pending'): ?>
                        <div class="flex gap-2 mt-3">
                            <form action="/requests/cancel/<?= $req['id'] ?>" method="POST"
                                  onsubmit="return confirm('Cancel this request?')">
                                <button type="submit" class="inline-flex items-center gap-1.5 border border-gray-300 text-gray-500 hover:text-red-600 hover:border-red-300 hover:bg-red-50 text-xs font-semibold px-4 py-2 rounded-lg transition-all">
                                    Cancel Request
                                </button>
                            </form>
                            <a href="/items/view/<?= $req['item_id'] ?>" class="inline-flex items-center gap-1 text-brand-500 hover:text-brand-700 text-xs font-semibold px-3 py-2 rounded-lg transition-all">
                                View Item →
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    <?php endif; ?>

</main>

<?php require __DIR__ . '/../dashboard/footer.php'; ?>
