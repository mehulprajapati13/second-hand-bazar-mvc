<?php
$pageTitle = 'Dashboard';
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
                
                <!-- Welcome Banner -->
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-orange-500 to-orange-600 shadow-xl shadow-orange-500/20 mb-8 border border-orange-400/30">
                    <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 rounded-full bg-white opacity-10 blur-3xl pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 -mb-16 -ml-16 w-48 h-48 rounded-full bg-orange-300 opacity-20 blur-2xl pointer-events-none"></div>
                    
                    <div class="relative z-10 p-8 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="text-white">
                            <h2 class="text-3xl font-extrabold tracking-tight mb-2 drop-shadow-sm">Welcome back, <?= htmlspecialchars($_SESSION['user']['name'] ?? 'User') ?>! 👋</h2>
                            <p class="text-orange-100 text-base md:text-lg max-w-xl font-medium m-0">Manage your listings, track requests, and discover what's new in your city.</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto shrink-0">
                            <a href="/items/add" class="flex items-center justify-center gap-2 bg-white text-orange-600 font-bold px-6 py-3 rounded-xl hover:bg-orange-50 transition-colors shadow-sm no-underline">
                                <i class="bi bi-plus-lg"></i> Post Listing
                            </a>
                            <a href="/browse" class="flex items-center justify-center gap-2 bg-orange-600/50 hover:bg-orange-600/70 text-white font-semibold border border-orange-400/50 px-6 py-3 rounded-xl transition-all backdrop-blur-sm no-underline">
                                <i class="bi bi-search"></i> Browse Items
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <?php
                $cards = [
                    ['Total Items',       $summary['total_items']        ?? 0, 'bg-blue-50',   'text-blue-600',   'bi-grid-fill'],
                    ['Active Items',      $summary['active_items']       ?? 0, 'bg-emerald-50','text-emerald-600','bi-check-circle-fill'],
                    ['Reserved',          $summary['reserved_items']     ?? 0, 'bg-yellow-50', 'text-yellow-600', 'bi-clock-fill'],
                    ['Sold',              $summary['sold_items']         ?? 0, 'bg-purple-50', 'text-purple-600', 'bi-bag-check-fill'],
                    ['Req Received',      $summary['requests_received']  ?? 0, 'bg-orange-50', 'text-orange-600', 'bi-inbox-fill'],
                    ['Req Sent',          $summary['requests_sent']      ?? 0, 'bg-cyan-50',   'text-cyan-600',   'bi-send-fill'],
                ];
                ?>
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-extrabold text-gray-900 m-0 tracking-tight">Overview</h4>
                    <button class="text-xs font-bold text-orange-500 hover:text-orange-600 flex items-center gap-1 bg-orange-50 px-3 py-1.5 rounded-lg transition-colors border-0">
                        <i class="bi bi-download"></i> Export
                    </button>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-8">
                    <?php foreach ($cards as $i => [$label, $value, $iconBg, $iconColor, $iconClass]): ?>
                    <div class="bg-white border border-gray-100 rounded-xl p-3 shadow-sm hover:shadow-md transition-shadow flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg shrink-0 <?= $iconBg ?> <?= $iconColor ?> flex items-center justify-center text-lg">
                            <i class="bi <?= $iconClass ?>"></i>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-xl font-extrabold text-gray-900 leading-none mb-0.5"><?= htmlspecialchars((string)$value) ?></h3>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide truncate m-0"><?= htmlspecialchars($label) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Line Chart -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                        <div class="flex justify-between items-center mb-4">
                            <h5 class="font-bold text-gray-800 text-lg m-0">Activity Distribution</h5>
                        </div>
                        <div class="h-64">
                            <canvas id="activityChart"></canvas>
                        </div>
                    </div>
                    <!-- Bar Chart -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                        <div class="flex justify-between items-center mb-4">
                            <h5 class="font-bold text-gray-800 text-lg m-0">Listing Performance</h5>
                        </div>
                        <div class="h-64">
                            <canvas id="performanceChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Listings -->
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden mb-8">
                    <div class="border-b border-gray-100 bg-white p-5 flex justify-between items-center">
                        <div>
                            <h5 class="font-extrabold text-gray-900 text-lg m-0">Recent Listings</h5>
                            <p class="text-sm text-gray-400 font-medium m-0 mt-1">Your most recently posted items</p>
                        </div>
                        <a href="/items" class="text-sm font-bold text-orange-500 hover:text-orange-600 flex items-center gap-1 group no-underline">
                            View all <i class="bi bi-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                    
                    <div class="p-5 bg-gray-50/30">
                        <?php if (empty($recentItems)): ?>
                        <div class="text-center py-10 bg-white rounded-xl border border-dashed border-gray-200">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                <i class="bi bi-box-seam text-4xl"></i>
                            </div>
                            <h5 class="text-lg font-bold text-gray-800 mb-2">No listings yet</h5>
                            <p class="text-gray-500 text-sm max-w-sm mx-auto mb-6">You haven't posted any items for sale or rent. Get started by posting your first item!</p>
                            <a href="/items/add" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2.5 rounded-full transition-colors shadow-sm shadow-orange-500/20 no-underline">
                                <i class="bi bi-plus-lg"></i> Post First Item
                            </a>
                        </div>
                        <?php else: ?>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                            <?php foreach (array_slice($recentItems, 0, 4) as $item): ?>
                            <a href="/items/view/<?= $item['id'] ?>" class="group no-underline block h-full">
                                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-orange-500/10 hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-full">
                                    <div class="relative pt-[100%] bg-gray-100 overflow-hidden">
                                        <?php if (!empty($item['image'])): ?>
                                            <img src="/uploads/items/<?= htmlspecialchars(getRealImage($item['image'])) ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="">
                                        <?php else: ?>
                                            <div class="absolute inset-0 flex items-center justify-center text-gray-300">
                                                <i class="bi bi-image text-4xl"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="absolute top-2 right-2 bg-white/90 backdrop-blur text-xs font-bold px-2 py-1 rounded-md text-gray-700 shadow-sm">
                                            New
                                        </div>
                                    </div>
                                    <div class="p-4 flex flex-col flex-grow">
                                        <h6 class="font-bold text-gray-800 text-sm mb-1 truncate"><?= htmlspecialchars($item['title']) ?></h6>
                                        <div class="font-extrabold text-lg text-orange-600 mt-auto">₹<?= number_format((float)$item['price'], 0) ?></div>
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
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Front-end only charts using Chart.js
    const activityCtx = document.getElementById('activityChart');
    if(activityCtx) {
        new Chart(activityCtx, {
            type: 'doughnut',
            data: {
                labels: ['Active Items', 'Sold Items', 'Requests Received', 'Requests Sent'],
                datasets: [{
                    data: [
                        <?= $summary['active_items'] ?? 0 ?>, 
                        <?= $summary['sold_items'] ?? 0 ?>, 
                        <?= $summary['requests_received'] ?? 0 ?>, 
                        <?= $summary['requests_sent'] ?? 0 ?>
                    ],
                    backgroundColor: [
                        '#10b981', // emerald-500
                        '#8b5cf6', // violet-500
                        '#f59e0b', // amber-500
                        '#06b6d4'  // cyan-500
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: { 
                    legend: { 
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                family: "'Inter', sans-serif",
                                size: 12,
                                weight: '600'
                            }
                        }
                    } 
                }
            }
        });
    }

    const performanceCtx = document.getElementById('performanceChart');
    if(performanceCtx) {
        new Chart(performanceCtx, {
            type: 'bar',
            data: {
                labels: ['Active', 'Sold', 'Reserved', 'Archived'],
                datasets: [{
                    label: 'Listings',
                    data: [<?= $summary['active_items'] ?? 5 ?>, <?= $summary['sold_items'] ?? 2 ?>, <?= $summary['reserved_items'] ?? 1 ?>, 0],
                    backgroundColor: '#f97316',
                    borderRadius: 6,
                    barPercentage: 0.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [2, 4], color: '#f3f4f6' }, border: { display: false } },
                    x: { grid: { display: false }, border: { display: false } }
                }
            }
        });
    }
});
</script>

<?php require __DIR__ . '/../includes/footer.php'; ?>
