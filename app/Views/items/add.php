<?php require __DIR__ . '/../dashboard/header.php'; ?>

<main class="px-4 sm:px-6 lg:px-8 py-6">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-gray-500 mb-5">
        <a href="/dashboard" class="hover:text-brand-500">Home</a>
        <span>/</span>
        <a href="/items/my" class="hover:text-brand-500">My Listings</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">Add Item</span>
    </div>

    <div class="max-w-2xl">
        <!-- Card -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <!-- Card Header -->
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                <h1 class="text-lg font-bold text-gray-900">Add New Listing</h1>
                <p class="text-sm text-gray-500 mt-0.5">Fill in the details below and your item goes live instantly</p>
            </div>

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
            <form action="/items/add" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Item Title <span class="text-red-500">*</span>
                    </label>
                    <input id="title" name="title" type="text"
                        value="<?= htmlspecialchars($old['title'] ?? '') ?>"
                        placeholder="e.g. iPhone 12, Wooden Study Table, Guitar"
                        class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors placeholder-gray-400" />
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="4"
                        placeholder="Describe the condition, usage, any accessories included..."
                        class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors placeholder-gray-400 resize-none"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
                    <p class="text-xs text-gray-400 mt-1">Tip: Better descriptions = faster sales</p>
                </div>

                <!-- Price / City / Mode Row -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Price (₹) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-semibold">₹</span>
                            <input id="price" name="price" type="number" min="1" step="1"
                                value="<?= htmlspecialchars($old['price'] ?? '') ?>"
                                placeholder="0"
                                class="w-full pl-7 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors" />
                        </div>
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            City <span class="text-red-500">*</span>
                        </label>
                        <input id="city" name="city" type="text"
                            value="<?= htmlspecialchars($old['city'] ?? '') ?>"
                            placeholder="e.g. Mumbai, Jaipur"
                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors placeholder-gray-400" />
                    </div>
                    <div>
                        <label for="mode" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Listing Type <span class="text-red-500">*</span>
                        </label>
                        <select id="mode" name="mode"
                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-1 focus:ring-brand-200 outline-none transition-colors bg-white">
                            <option value="">Select type</option>
                            <option value="sell" <?= ($old['mode']??'')==='sell'?'selected':'' ?>>For Sale</option>
                            <option value="rent" <?= ($old['mode']??'')==='rent'?'selected':'' ?>>For Rent</option>
                        </select>
                    </div>
                </div>

                <!-- Image Upload -->
                <div>
                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-1.5">Item Photo</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-brand-400 transition-colors">
                        <svg class="mx-auto h-8 w-8 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-sm text-gray-500 mb-2">Click to upload or drag & drop</p>
                        <p class="text-xs text-gray-400 mb-3">JPG, PNG, WEBP · Max 5MB</p>
                        <input id="image" name="image" type="file" accept="image/*"
                            class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 transition-colors cursor-pointer" />
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Items with photos sell 3× faster</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-2 border-t border-gray-100">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-bold px-6 py-3 rounded-lg text-sm transition-colors shadow-sm">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Post Listing
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
