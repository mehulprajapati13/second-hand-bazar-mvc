<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password | SecondHand Bazaar</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:["DM Sans","sans-serif"]},colors:{brand:{50:'#fff7ed',100:'#ffedd5',400:'#fb923c',500:'#f97316',600:'#ea580c',700:'#c2410c'}}}}};</script>
</head>
<body class="bg-gray-50 font-sans text-gray-800 min-h-screen flex items-center justify-center px-4 py-12">

<div class="w-full max-w-sm">
    <div class="text-center mb-8">
        <div class="h-16 w-16 rounded-2xl bg-green-50 border-2 border-green-200 flex items-center justify-center mx-auto mb-4">
            <svg class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h1 class="text-xl font-bold text-gray-900">Set new password</h1>
        <p class="text-sm text-gray-500 mt-1">Choose a strong password for your account</p>
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

        <form action="/reset-password" method="POST" class="space-y-4">
            <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>" />
            <input type="hidden" name="otp" value="<?= htmlspecialchars($otp ?? '') ?>" />

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">New Password <span class="text-red-500">*</span></label>
                <input id="password" name="password" type="password" placeholder="Min 8 characters"
                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors placeholder-gray-400" />
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm Password <span class="text-red-500">*</span></label>
                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Re-enter new password"
                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors placeholder-gray-400" />
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs text-gray-600">
                <p class="font-semibold mb-1">Password must:</p>
                <ul class="space-y-0.5 list-disc list-inside text-gray-500">
                    <li>Be at least 8 characters long</li>
                    <li>Contain letters and numbers</li>
                </ul>
            </div>

            <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white font-bold py-3 rounded-lg text-sm transition-colors shadow-sm">
                Reset Password
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-5">
            <a href="/login" class="font-semibold text-gray-600 hover:text-brand-500">← Back to login</a>
        </p>
    </div>
</div>

</body>
</html>
