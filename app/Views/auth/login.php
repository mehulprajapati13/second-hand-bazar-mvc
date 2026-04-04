<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | SecondHand Bazaar</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ["DM Sans","sans-serif"] },
                    colors: { brand: { 50:'#fff7ed',100:'#ffedd5',400:'#fb923c',500:'#f97316',600:'#ea580c',700:'#c2410c' } }
                }
            }
        };
    </script>
</head>
<body class="bg-gray-100 font-sans text-gray-800 min-h-screen">

<div class="min-h-screen flex">
    <!-- Left Panel -->
    <div class="hidden lg:flex lg:flex-1 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white flex-col justify-between p-12">
        <a href="/" class="flex items-center gap-2">
            <div class="h-9 w-9 rounded-lg bg-brand-500 flex items-center justify-center">
                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0v4a1 1 0 001 1h1M9 21a1 1 0 110-2 1 1 0 010 2zm8 0a1 1 0 110-2 1 1 0 010 2z"/></svg>
            </div>
            <p class="text-sm font-bold">SecondHand<span class="text-brand-400">Bazaar</span></p>
        </a>
        <div class="space-y-6">
            <h2 class="text-3xl font-bold leading-snug">India's most trusted<br/>secondhand marketplace</h2>
            <div class="space-y-3">
                <?php foreach(['OTP-verified buyers and sellers','Free to list — no commission taken'] as $f): ?>
                <div class="flex items-center gap-3 text-gray-300 text-sm">
                    <svg class="h-4 w-4 text-brand-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <?= $f ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <p class="text-xs text-gray-500">© <?= date('Y') ?> SecondHand Bazaar</p>
    </div>

    <!-- Right Panel - Form -->
    <div class="flex-1 flex items-center justify-center px-4 py-10 bg-gray-50">
        <div class="w-full max-w-sm">
            <!-- Mobile Logo -->
            <div class="flex justify-center mb-8 lg:hidden">
                <a href="/" class="flex items-center gap-2">
                    <div class="h-9 w-9 rounded-lg bg-brand-500 flex items-center justify-center">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0v4a1 1 0 001 1h1M9 21a1 1 0 110-2 1 1 0 010 2zm8 0a1 1 0 110-2 1 1 0 010 2z"/></svg>
                    </div>
                    <p class="text-sm font-bold text-gray-900">SecondHand<span class="text-brand-500">Bazaar</span></p>
                </a>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                <div class="mb-6">
                    <h1 class="text-xl font-bold text-gray-900">Welcome back</h1>
                    <p class="text-sm text-gray-500 mt-1">Sign in to your account to continue</p>
                </div>

                <!-- Errors -->
                <?php if (!empty($errors)): ?>
                <div class="mb-5 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                    <ul class="space-y-0.5 text-sm text-red-600">
                        <?php foreach ($errors as $error): ?>
                        <li class="flex items-start gap-2">
                            <svg class="h-4 w-4 text-red-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <?= htmlspecialchars($error) ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php if (!empty($unverified)): ?>
                    <form action="/resend-otp" method="POST" class="mt-3 pt-3 border-t border-red-200">
                        <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>" />
                        <button type="submit" class="text-sm font-semibold text-brand-500 hover:text-brand-700">Resend verification OTP →</button>
                    </form>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Success -->
                <?php if (!empty($success)): ?>
                <div class="mb-5 bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-sm text-green-700 flex items-center gap-2">
                    <svg class="h-4 w-4 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <?= htmlspecialchars($success) ?>
                </div>
                <?php endif; ?>

                <!-- Form -->
                <form action="/login" method="POST" class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email address</label>
                        <input id="email" name="email" type="email" value="<?= htmlspecialchars($email ?? '') ?>"
                            placeholder="name@example.com"
                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors placeholder-gray-400" />
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="text-sm font-semibold text-gray-700">Password</label>
                            <a href="/forgot-password" class="text-xs font-semibold text-brand-500 hover:text-brand-700">Forgot password?</a>
                        </div>
                        <input id="password" name="password" type="password" placeholder="Enter your password"
                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors placeholder-gray-400" />
                    </div>
                    <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white font-bold py-3 rounded-lg text-sm transition-colors shadow-sm mt-2">
                        Sign In
                    </button>
                </form>

                <p class="text-center text-sm text-gray-500 mt-5">
                    New to SecondHand Bazaar?
                    <a href="/register" class="font-semibold text-brand-500 hover:text-brand-700">Create account →</a>
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
