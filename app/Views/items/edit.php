<?php require __DIR__ . '/../dashboard/header.php'; ?>

<main class="px-4 sm:px-6 lg:px-8 py-6">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-gray-500 mb-5">
        <a href="/dashboard" class="hover:text-brand-500">Home</a>
        <span>/</span>
        <a href="/items/my" class="hover:text-brand-500">My Listings</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">Edit Item</span>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-bold text-gray-900">Edit Listing</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Update your item details below</p>
                </div>
                <a href="/items/my" class="text-sm font-semibold text-brand-500 hover:text-brand-700">← Back</a>
            </div>

            <!-- Current Image Preview -->
            <?php if (!empty($item['image'])): ?>
            <div class="px-6 pt-5">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Current Image</p>
                <div class="relative w-32 h-24 rounded-xl overflow-hidden border border-gray-200">
                    <img src="/uploads/items/<?= htmlspecialchars($item['image']) ?>" alt="Current" class="w-full h-full object-cover" />
                    <div class="absolute inset-0 bg-black/20 flex items-end">
                        <span class="text-white text-xs font-semibold px-2 py-1 w-full text-center bg-black/40">Current</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Errors -->
            <?php if (!empty($errors)): ?>
            <div class="mx-6 mt-5 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                <div class="flex items-start gap-2">
                    <svg class="h-4 w-4 text-red-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <ul class="space-y-0.5 text-sm text-red-600">
                        <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

            <!-- Form -->
            <form action="/items/edit/<?= $item['id'] ?>" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">

                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-1.5">Item Title <span class="text-red-500">*</span></label>
                    <input id="title" name="title" type="text" value="<?= htmlspecialchars($item['title']) ?>"
                        class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors" />
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">Description <span class="text-red-500">*</span></label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors resize-none"><?= htmlspecialchars($item['description']) ?></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-1.5">Price (₹) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-semibold">₹</span>
                            <input id="price" name="price" type="number" min="1" step="1" value="<?= htmlspecialchars($item['price']) ?>"
                                class="w-full pl-7 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors" />
                        </div>
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-semibold text-gray-700 mb-1.5">City <span class="text-red-500">*</span></label>
                        <input id="city" name="city" type="text" value="<?= htmlspecialchars($item['city']) ?>"
                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors" />
                    </div>
                    <div>
                        <label for="mode" class="block text-sm font-semibold text-gray-700 mb-1.5">Listing Type <span class="text-red-500">*</span></label>
                        <select id="mode" name="mode"
                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors bg-white">
                            <option value="sell" <?= $item['mode']==='sell'?'selected':'' ?>>For Sale</option>
                            <option value="rent" <?= $item['mode']==='rent'?'selected':'' ?>>For Rent</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-1.5">Replace Photo</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 text-center hover:border-brand-400 transition-colors">
                        <p class="text-sm text-gray-500 mb-1">Upload a new photo to replace the current one</p>
                        <p class="text-xs text-gray-400 mb-3">JPG, PNG, WEBP · Max 5MB</p>
                        <input id="image" name="image" type="file" accept="image/*"
                            class="block mx-auto text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 cursor-pointer" />
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-2 border-t border-gray-100">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-bold px-6 py-3 rounded-lg text-sm transition-colors shadow-sm">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Save Changes
                    </button>
                    <a href="/items/my" class="inline-flex items-center justify-center gap-2 border border-gray-300 text-gray-600 hover:bg-gray-50 font-semibold px-6 py-3 rounded-lg text-sm transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

</main>

<?php require __DIR__ . '/../dashboard/footer.php'; ?>
