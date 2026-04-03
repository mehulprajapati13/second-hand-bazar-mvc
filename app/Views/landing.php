<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SecondHand Bazaar | Buy & Sell Pre-Owned Items</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ["DM Sans", "sans-serif"] },
                    colors: {
                        brand: { 50:'#fff7ed',100:'#ffedd5',400:'#fb923c',500:'#f97316',600:'#ea580c',700:'#c2410c' }
                    }
                }
            }
        };
    </script>
    <style>
        .hero-bg { background: linear-gradient(135deg, #1e293b 0%, #0f172a 60%, #1e293b 100%); }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">

<!-- HEADER -->
<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between gap-4">
        <a href="/" class="flex items-center gap-2">
            <div class="h-9 w-9 rounded-lg bg-brand-500 flex items-center justify-center">
                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0v4a1 1 0 001 1h1M9 21a1 1 0 110-2 1 1 0 010 2zm8 0a1 1 0 110-2 1 1 0 010 2z"/>
                </svg>
            </div>
            <p class="text-base font-bold text-gray-900">SecondHand<span class="text-brand-500">Bazaar</span></p>
        </a>
        <div class="flex items-center gap-3">
            <a href="/login"
               class="hidden sm:inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold text-gray-700 border border-gray-300 hover:border-brand-400 hover:text-brand-600 transition-colors">
                Login
            </a>
            <a href="/register"
               class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold text-white bg-brand-500 hover:bg-brand-600 transition-colors shadow-sm">
                Get Started
            </a>
        </div>
    </div>
</header>

<!-- HERO -->
<section class="hero-bg text-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-16 lg:py-20 flex flex-col lg:flex-row items-center gap-12">
        <div class="flex-1 space-y-6">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight">
                Buy & Sell <span class="text-brand-400">Pre-Owned</span><br/>Items Near You
            </h1>
            <p class="text-gray-300 text-base sm:text-lg max-w-lg leading-relaxed">
                A trusted secondhand marketplace. Verified accounts, OTP-secured, real buyers in your city.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="/register"
                   class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 px-6 py-3 rounded-lg text-sm font-bold text-white shadow-lg transition-colors">
                    Start Selling — Free
                </a>
                <a href="/login"
                   class="inline-flex items-center gap-2 bg-white/10 border border-white/25 hover:bg-white/20 px-6 py-3 rounded-lg text-sm font-bold text-white transition-colors">
                    Login →
                </a>
            </div>
            <div class="flex flex-wrap gap-5 text-sm pt-1">
                <?php foreach(['OTP Verified Users', 'Free to List', 'No Middleman'] as $t): ?>
                <span class="flex items-center gap-1.5 text-gray-300">
                    <svg class="h-4 w-4 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <?= $t ?>
                </span>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Simple info card -->
        <div class="w-full lg:w-72 flex-shrink-0">
            <div class="bg-white/10 backdrop-blur border border-white/20 rounded-2xl p-6 space-y-4">
                <p class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Why SecondHand Bazaar?</p>
                <?php foreach([
                    ['🛡️', 'OTP Verified',    'Only real, verified users can list or request.'],
                    ['📨', 'Request System',  'Accept or decline buyers. Stay in control.'],
                    ['📍', 'Hyper Local',     'Find buyers and sellers in your own city.'],
                    ['⚡', 'Quick Listings',  'Post an item in under 60 seconds.'],
                ] as [$ico, $title, $desc]): ?>
                <div class="flex items-start gap-3">
                    <span class="text-lg flex-shrink-0"><?= $ico ?></span>
                    <div>
                        <p class="text-sm font-semibold text-white"><?= $title ?></p>
                        <p class="text-xs text-gray-400 mt-0.5"><?= $desc ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
                <a href="/register"
                   class="block text-center bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold py-3 rounded-xl transition-colors mt-2">
                    Create Free Account →
                </a>
            </div>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="bg-white border-b border-gray-100 py-14">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-gray-900">How It Works</h2>
            <p class="text-gray-500 mt-2 text-sm">Simple, fast and secure for buyers and sellers alike</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach([
                ['01','👤','Create Account',   'Register with email + OTP verification. Your identity stays safe.'],
                ['02','📋','List Your Item',   'Upload photos, set price and describe condition. Live instantly.'],
                ['03','📨','Receive Requests', 'Buyers send requests. Review and approve who you want.'],
                ['04','🤝','Close the Deal',   'Meet locally, hand off the item, mark as sold. Simple!'],
            ] as [$n, $icon, $title, $desc]): ?>
            <div class="p-6 bg-gray-50 border border-gray-200 rounded-2xl">
                <span class="text-3xl"><?= $icon ?></span>
                <p class="text-xs font-bold text-brand-500 mt-3 mb-1 uppercase tracking-wider">Step <?= $n ?></p>
                <h3 class="font-bold text-gray-900 text-sm mb-2"><?= $title ?></h3>
                <p class="text-gray-500 text-xs leading-relaxed"><?= $desc ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="bg-brand-500 py-14">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center space-y-4">
        <h2 class="text-2xl sm:text-3xl font-bold text-white">Ready to Sell Your First Item?</h2>
        <p class="text-brand-100 text-sm sm:text-base">Takes less than 2 minutes. Free to list.</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center pt-2">
            <a href="/register"
               class="inline-flex items-center justify-center bg-white text-brand-600 hover:bg-gray-50 font-bold px-8 py-3 rounded-lg text-sm shadow-lg transition-colors">
                Create Free Account
            </a>
            <a href="/login"
               class="inline-flex items-center justify-center bg-brand-600 border border-white/30 text-white hover:bg-brand-700 font-semibold px-8 py-3 rounded-lg text-sm transition-colors">
                Sign In
            </a>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-gray-900 text-gray-400">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="h-7 w-7 rounded-lg bg-brand-500 flex items-center justify-center">
                    <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0v4a1 1 0 001 1h1M9 21a1 1 0 110-2 1 1 0 010 2zm8 0a1 1 0 110-2 1 1 0 010 2z"/>
                    </svg>
                </div>
                <p class="text-white font-bold text-sm">SecondHand<span class="text-brand-400">Bazaar</span></p>
            </div>
            <div class="flex gap-6 text-xs">
                <a href="/login"     class="hover:text-white transition-colors">Login</a>
                <a href="/register"  class="hover:text-white transition-colors">Register</a>
            </div>
            <p class="text-xs">© <?= date('Y') ?> SecondHand Bazaar</p>
        </div>
    </div>
</footer>

</body>
</html>
