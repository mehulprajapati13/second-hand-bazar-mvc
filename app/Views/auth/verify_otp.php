<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verify OTP | SecondHand Bazaar</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:["DM Sans","sans-serif"]},colors:{brand:{50:'#fff7ed',100:'#ffedd5',400:'#fb923c',500:'#f97316',600:'#ea580c',700:'#c2410c'}}}}};</script>
    <style>
        .otp-input { letter-spacing: 0.4em; font-size: 1.5rem; text-align: center; }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800 min-h-screen flex items-center justify-center px-4 py-12">

<div class="w-full max-w-sm">
    <div class="text-center mb-8">
        <div class="h-16 w-16 rounded-2xl bg-brand-50 border-2 border-brand-200 flex items-center justify-center mx-auto mb-4">
            <svg class="h-8 w-8 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h1 class="text-xl font-bold text-gray-900">Check your email</h1>
        <p class="text-sm text-gray-500 mt-1">We sent a 6-digit OTP to your email address</p>
        <?php if (!empty($email)): ?>
        <p class="text-sm font-semibold text-gray-700 mt-1"><?= htmlspecialchars($email) ?></p>
        <?php endif; ?>
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
        <div class="mb-5 bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-sm text-green-700">
            <?= htmlspecialchars($success) ?>
        </div>
        <?php endif; ?>

        <form action="/verify-otp" method="POST" class="space-y-5">
            <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>" />
            <div>
                <label for="otp" class="block text-sm font-semibold text-gray-700 mb-1.5 text-center">Enter 6-digit OTP</label>
                <input id="otp" name="otp" type="text" maxlength="6" inputmode="numeric" autocomplete="one-time-code"
                    placeholder="— — — — — —"
                    class="otp-input w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors placeholder-gray-300" />
            </div>
            <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white font-bold py-3 rounded-lg text-sm transition-colors shadow-sm">
                Verify OTP
            </button>
        </form>

        <div class="mt-5 pt-5 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-500 mb-2">Didn't receive the OTP?</p>
            <form action="/resend-otp" method="POST">
                <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>" />
                <button type="submit" class="text-sm font-semibold text-brand-500 hover:text-brand-700 transition-colors">
                    Resend OTP
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-gray-500 mt-3">
            <a href="/login" class="font-semibold text-gray-600 hover:text-brand-500">← Back to login</a>
        </p>
    </div>
</div>

</body>
</html>
