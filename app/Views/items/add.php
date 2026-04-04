<?php
$pageTitle = 'Add New Listing';
require __DIR__ . '/../includes/dashboard-header.php';
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <a href="/dashboard">Home</a>
    <span class="sep">/</span>
    <a href="/items">My Listings</a>
    <span class="sep">/</span>
    <span class="current">Add Item</span>
</div>

<div class="max-w-2xl">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-header-title">Add New Listing</div>
                <div class="card-header-sub">Fill in the details below and your item goes live instantly</div>
            </div>
        </div>

        <!-- Errors -->
        <?php if (!empty($errors)): ?>
        <div style="margin:16px 24px 0;">
            <div class="alert alert-red" style="flex-direction:column;gap:3px;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;flex-shrink:0;align-self:flex-start;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <?php foreach ($errors as $error): ?>
                <div><?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="card-body">
            <form action="/items/add" method="POST" enctype="multipart/form-data" class="space-y-5">

                <!-- Title -->
                <div class="form-group">
                    <label for="title" class="form-label">Item Title <span class="req">*</span></label>
                    <input id="title" name="title" type="text"
                           value="<?= htmlspecialchars($old['title'] ?? '') ?>"
                           placeholder="e.g. iPhone 12, Wooden Study Table, Guitar"
                           class="form-control" />
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description" class="form-label">Description <span class="req">*</span></label>
                    <textarea id="description" name="description" rows="4"
                              placeholder="Describe the condition, usage, any accessories included…"
                              class="form-control"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
                    <span class="form-hint">Tip: Better descriptions = faster sales</span>
                </div>

                <!-- Price / City / Mode -->
                <div class="form-grid-3">
                    <div class="form-group">
                        <label for="price" class="form-label">Price (₹) <span class="req">*</span></label>
                        <div class="input-prefix-wrap">
                            <span class="input-prefix">₹</span>
                            <input id="price" name="price" type="number" min="1" step="1"
                                   value="<?= htmlspecialchars($old['price'] ?? '') ?>"
                                   placeholder="0"
                                   class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="city" class="form-label">City <span class="req">*</span></label>
                        <input id="city" name="city" type="text"
                               value="<?= htmlspecialchars($old['city'] ?? '') ?>"
                               placeholder="e.g. Mumbai"
                               class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="mode" class="form-label">Listing Type <span class="req">*</span></label>
                        <select id="mode" name="mode" class="form-control">
                            <option value="">Select type</option>
                            <option value="sell" <?= ($old['mode'] ?? '') === 'sell' ? 'selected' : '' ?>>For Sale</option>
                            <option value="rent" <?= ($old['mode'] ?? '') === 'rent' ? 'selected' : '' ?>>For Rent</option>
                        </select>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="form-group">
                    <label class="form-label">Item Photo</label>
                    <div class="upload-zone" onclick="document.getElementById('image').click();">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p>Click to upload or drag &amp; drop</p>
                        <small>JPG, PNG, WEBP · Max 5MB</small>
                        <input id="image" name="image" type="file" accept="image/*"
                               class="file-input" style="margin-top:10px;" />
                    </div>
                    <span class="form-hint">Items with photos sell 3× faster</span>
                </div>

                <!-- Actions -->
                <div style="display:flex;flex-wrap:wrap;gap:12px;padding-top:10px;border-top:1px solid var(--border-light);">
                    <button type="submit" class="btn btn-primary btn-lg" style="flex:1;min-width:140px;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Post Listing
                    </button>
                    <a href="/items" class="btn btn-secondary btn-lg" style="flex:1;min-width:100px;justify-content:center;">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/dashboard-footer.php'; ?>
