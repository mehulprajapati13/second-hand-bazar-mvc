<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Account | SecondHand Bazaar</title>
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

<?php $errors = $errors ?? []; $old = $old ?? []; ?>

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
            <h2 class="text-3xl font-bold leading-snug">Start selling in<br/>under 2 minutes</h2>
            <div class="space-y-3">
                <?php foreach(['Free account — no credit card needed','List items and reach buyers nearby','OTP verification keeps everyone safe'] as $f): ?>
                <div class="flex items-center gap-3 text-gray-300 text-sm">
                    <svg class="h-4 w-4 text-brand-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <?= $f ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <p class="text-xs text-gray-500">© <?= date('Y') ?> SecondHand Bazaar</p>
    </div>

    <!-- Right Panel -->
    <div class="flex-1 flex items-center justify-center px-4 py-10 bg-gray-50">
        <div class="w-full max-w-md">
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
                    <h1 class="text-xl font-bold text-gray-900">Create your account</h1>
                    <p class="text-sm text-gray-500 mt-1">Join thousands of buyers and sellers in your city</p>
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
                </div>
                <?php endif; ?>

                <form action="/register" method="POST" class="space-y-4">
                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                        <input id="name" name="name" type="text" value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                            placeholder="Rahul Sharma"
                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors placeholder-gray-400" />
                    </div>

                    <!-- Email + Phone -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                            <input id="email" name="email" type="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                                placeholder="name@example.com"
                                class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors placeholder-gray-400" />
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1.5">Phone <span class="text-red-500">*</span></label>
                            <input id="phone" name="phone" type="tel" value="<?= htmlspecialchars($old['phone'] ?? '') ?>"
                                placeholder="9876543210"
                                class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors placeholder-gray-400" />
                        </div>
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-semibold text-gray-700 mb-1.5">City <span class="text-red-500">*</span></label>
                        <input id="city" name="city" type="text" value="<?= htmlspecialchars($old['city'] ?? '') ?>"
                            placeholder="Mumbai, Delhi, Jaipur..."
                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors placeholder-gray-400" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                        <input id="password" name="password" type="password" placeholder="Min 8 characters"
                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors placeholder-gray-400" />
                    </div>

                    <!-- Password Confirm -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm Password <span class="text-red-500">*</span></label>
                        <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Re-enter password"
                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors placeholder-gray-400" />
                    </div>

                    <!-- OTP Note -->
                    <div class="bg-brand-50 border border-brand-100 rounded-xl px-4 py-3 flex items-start gap-2 text-xs text-brand-700">
                        <svg class="h-4 w-4 text-brand-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        A verification OTP will be sent to your email to activate the account.
                    </div>

                    <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white font-bold py-3 rounded-lg text-sm transition-colors shadow-sm mt-1">
                        Create Account
                    </button>
                </form>

                <p class="text-center text-sm text-gray-500 mt-5">
                    Already have an account?
                    <a href="/login" class="font-semibold text-brand-500 hover:text-brand-700">Sign in →</a>
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
