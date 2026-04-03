<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password | SecondHand Bazaar</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:["DM Sans","sans-serif"]},colors:{brand:{50:'#fff7ed',100:'#ffedd5',400:'#fb923c',500:'#f97316',600:'#ea580c',700:'#c2410c'}}}}};</script>
</head>
<body class="bg-gray-50 font-sans text-gray-800 min-h-screen flex items-center justify-center px-4 py-12">

<div class="w-full max-w-sm">
    <div class="text-center mb-8">
        <a href="/" class="inline-flex items-center gap-2">
            <div class="h-10 w-10 rounded-xl bg-brand-500 flex items-center justify-center mx-auto">
                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0v4a1 1 0 001 1h1M9 21a1 1 0 110-2 1 1 0 010 2zm8 0a1 1 0 110-2 1 1 0 010 2z"/></svg>
            </div>
        </a>
        <h1 class="text-xl font-bold text-gray-900 mt-4">Forgot your password?</h1>
        <p class="text-sm text-gray-500 mt-1">Enter your email and we'll send a reset OTP</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
        <?php if (!empty($errors)): ?>
        <div class="mb-5 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
            <ul class="space-y-0.5 text-sm text-red-600">
                <?php foreach ($errors as $error): ?><li><?= htmlspecialchars($error) ?></li><?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
        <div class="mb-5 bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-sm text-green-700 flex items-center gap-2">
            <svg class="h-4 w-4 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <?= htmlspecialchars($success) ?>
        </div>
        <?php endif; ?>

        <form action="/forgot-password" method="POST" class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email address</label>
                <input id="email" name="email" type="email" value="<?= htmlspecialchars($email ?? '') ?>"
                    placeholder="name@example.com"
                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors placeholder-gray-400" />
            </div>
            <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white font-bold py-3 rounded-lg text-sm transition-colors shadow-sm">
                Send Reset OTP
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-5">
            Remember your password?
            <a href="/login" class="font-semibold text-brand-500 hover:text-brand-700">Sign in →</a>
        </p>
    </div>
</div>

</body>
</html>
