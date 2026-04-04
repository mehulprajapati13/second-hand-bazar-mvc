<?php
$pageTitle = 'Edit Listing';
require __DIR__ . '/../includes/dashboard-header.php';

$itemId      = (int)($item['id']          ?? 0);
$title       = (string)($item['title']    ?? '');
$description = (string)($item['description'] ?? '');
$price       = (string)($item['price']    ?? '');
$city        = (string)($item['city']     ?? '');
$mode        = (string)($item['mode']     ?? 'sell');
$image       = $item['image']             ?? null;
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <a href="/dashboard">Home</a>
    <span class="sep">/</span>
    <a href="/items">My Listings</a>
    <span class="sep">/</span>
    <span class="current">Edit Item</span>
</div>

<div class="max-w-2xl">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-header-title">Edit Listing</div>
                <div class="card-header-sub">Update your item details below</div>
            </div>
            <a href="/items" class="btn btn-ghost btn-sm text-brand">← Back</a>
        </div>

        <!-- Current image preview -->
        <?php if (!empty($image)): ?>
        <div style="padding:18px 24px 0;">
            <div style="font-size:.6875rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--text-muted);margin-bottom:8px;">Current Image</div>
            <div style="position:relative;width:128px;height:96px;border-radius:var(--radius-md);overflow:hidden;border:1px solid var(--border);">
                <img src="/uploads/items/<?= htmlspecialchars((string)$image) ?>"
                     alt="Current" style="width:100%;height:100%;object-fit:cover;" />
                <div style="position:absolute;bottom:0;left:0;right:0;background:rgba(0,0,0,.45);text-align:center;padding:4px;font-size:.625rem;color:#fff;font-weight:600;">Current</div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Errors -->
        <?php if (!empty($errors)): ?>
        <div style="margin:16px 24px 0;">
            <div class="alert alert-red" style="flex-direction:column;gap:3px;">
                <?php foreach ($errors as $error): ?><div><?= htmlspecialchars($error) ?></div><?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="card-body">
            <form action="/items/edit/<?= $itemId ?>" method="POST" enctype="multipart/form-data" class="space-y-5">

                <div class="form-group">
                    <label for="title" class="form-label">Item Title <span class="req">*</span></label>
                    <input id="title" name="title" type="text"
                           value="<?= htmlspecialchars($title) ?>"
                           class="form-control" />
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description <span class="req">*</span></label>
                    <textarea id="description" name="description" rows="4"
                              class="form-control"><?= htmlspecialchars($description) ?></textarea>
                </div>

                <div class="form-grid-3">
                    <div class="form-group">
                        <label for="price" class="form-label">Price (₹) <span class="req">*</span></label>
                        <div class="input-prefix-wrap">
                            <span class="input-prefix">₹</span>
                            <input id="price" name="price" type="number" min="1" step="1"
                                   value="<?= htmlspecialchars($price) ?>"
                                   class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="city" class="form-label">City <span class="req">*</span></label>
                        <input id="city" name="city" type="text"
                               value="<?= htmlspecialchars($city) ?>"
                               class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="mode" class="form-label">Listing Type <span class="req">*</span></label>
                        <select id="mode" name="mode" class="form-control">
                            <option value="sell" <?= $mode === 'sell' ? 'selected' : '' ?>>For Sale</option>
                            <option value="rent" <?= $mode === 'rent' ? 'selected' : '' ?>>For Rent</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Replace Photo</label>
                    <div class="upload-zone">
                        <p>Upload a new photo to replace the current one</p>
                        <small>JPG, PNG, WEBP · Max 5MB</small>
                        <input id="image" name="image" type="file" accept="image/*"
                               class="file-input" />
                    </div>
                </div>

                <div style="display:flex;flex-wrap:wrap;gap:12px;padding-top:10px;border-top:1px solid var(--border-light);">
                    <button type="submit" class="btn btn-primary btn-lg" style="flex:1;min-width:140px;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Save Changes
                    </button>
                    <a href="/items" class="btn btn-secondary btn-lg" style="flex:1;min-width:100px;justify-content:center;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/dashboard-footer.php'; ?>
