<?php
$pageTitle = 'Add New Listing';
require __DIR__ . '/../includes/head.php';
require __DIR__ . '/../includes/navigation.php';
?>

<div style="background:#f8faf9;min-height:calc(100vh - 72px);padding:40px 0;">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <?php require __DIR__ . '/../includes/account-sidebar.php'; ?>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">

<!-- Breadcrumb -->
<div class="breadcrumb">
    <a href="/dashboard">Home</a>
    <span class="sep">/</span>
    <a href="/items">My Listings</a>
    <span class="sep">/</span>
    <span class="current">Add Item</span>
</div>

<div class="max-w-2xl" style="animation:fadeInUp .4s ease;">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-header-title">
                    <i class="bi bi-plus-circle me-2" style="color:var(--brand-color);"></i>Add New Listing
                </div>
                <div class="card-header-sub">Fill in the details below and your item goes live instantly</div>
            </div>
        </div>

        <div class="card-body">
            <!-- General error -->
            <?php if (!empty($errors['_general'])): ?>
                <div class="general-error">
                    <i class="bi bi-exclamation-circle"></i>
                    <span><?= htmlspecialchars($errors['_general']) ?></span>
                </div>
            <?php endif; ?>

            <form action="/items/add" method="POST" enctype="multipart/form-data" class="space-y-5">

                <!-- Title -->
                <div class="form-group">
                    <label for="title" class="form-label">Item Title <span class="req">*</span></label>
                    <input id="title" name="title" type="text"
                           value="<?= htmlspecialchars($old['title'] ?? '') ?>"
                           placeholder="e.g. iPhone 12, Wooden Study Table, Guitar"
                           class="form-control <?= !empty($errors['title']) ? 'is-invalid' : '' ?>" />
                    <?php if (!empty($errors['title'])): ?>
                        <span class="field-error"><?= htmlspecialchars($errors['title']) ?></span>
                    <?php endif; ?>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description" class="form-label">Description <span class="req">*</span></label>
                    <textarea id="description" name="description" rows="4"
                              placeholder="Describe the condition, usage, any accessories included…"
                              class="form-control <?= !empty($errors['description']) ? 'is-invalid' : '' ?>"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
                    <?php if (!empty($errors['description'])): ?>
                        <span class="field-error"><?= htmlspecialchars($errors['description']) ?></span>
                    <?php else: ?>
                        <span class="form-hint"><i class="bi bi-lightbulb me-1"></i>Tip: Better descriptions = faster sales</span>
                    <?php endif; ?>
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
                                   class="form-control <?= !empty($errors['price']) ? 'is-invalid' : '' ?>" />
                        </div>
                        <?php if (!empty($errors['price'])): ?>
                            <span class="field-error"><?= htmlspecialchars($errors['price']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="city" class="form-label">City <span class="req">*</span></label>
                        <input id="city" name="city" type="text"
                               value="<?= htmlspecialchars($old['city'] ?? '') ?>"
                               placeholder="e.g. Mumbai"
                               class="form-control <?= !empty($errors['city']) ? 'is-invalid' : '' ?>" />
                        <?php if (!empty($errors['city'])): ?>
                            <span class="field-error"><?= htmlspecialchars($errors['city']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="mode" class="form-label">Listing Type <span class="req">*</span></label>
                        <select id="mode" name="mode" class="form-control <?= !empty($errors['mode']) ? 'is-invalid' : '' ?>">
                            <option value="">Select type</option>
                            <option value="sell" <?= ($old['mode'] ?? '') === 'sell' ? 'selected' : '' ?>>For Sale</option>
                            <option value="rent" <?= ($old['mode'] ?? '') === 'rent' ? 'selected' : '' ?>>For Rent</option>
                        </select>
                        <?php if (!empty($errors['mode'])): ?>
                            <span class="field-error"><?= htmlspecialchars($errors['mode']) ?></span>
                        <?php endif; ?>
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
                    <?php if (!empty($errors['image'])): ?>
                        <span class="field-error"><?= htmlspecialchars($errors['image']) ?></span>
                    <?php else: ?>
                        <span class="form-hint"><i class="bi bi-camera me-1"></i>Items with photos sell 3× faster</span>
                    <?php endif; ?>
                </div>

                <!-- Actions -->
                <div style="display:flex;flex-wrap:wrap;gap:12px;padding-top:10px;border-top:1px solid var(--border-light);">
                    <button type="submit" class="btn btn-brand btn-lg shadow-sm" style="flex:1;min-width:140px;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Post Listing
                    </button>
                    <a href="/items" class="btn btn-secondary btn-lg" style="flex:1;min-width:100px;justify-content:center;">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
