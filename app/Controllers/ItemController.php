<?php

namespace Vendor\App\Controllers;

use Vendor\App\Core\Controller;
use Vendor\App\Services\ItemService;
use Vendor\App\Validation\ItemValidation;

class ItemController extends Controller
{
    private ItemService $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function showAdd(): void
    {
        $this->view('items/add', [
            'errors' => [],
            'old' => [],
        ]);
    }

    public function add(): void
    {
        $userId = $_SESSION['user']['id'];
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $mode = trim($_POST['mode'] ?? '');
        $city = trim($_POST['city'] ?? '');

        $old = compact('title', 'description', 'price', 'mode', 'city');

        $validator = new ItemValidation();
        $errors = $validator->validate($title, $description, $price, $mode, $city);

        if (!empty($errors)) {
            $this->view('items/add', ['errors' => $errors, 'old' => $old]);
            return;
        }

        $image = null;
        $errors = [];

        if (!empty($_FILES['image']['name'])) {
            $uploadResult = $this->handleImageUpload($_FILES['image']);

            if ($uploadResult['error']) {
                $this->view('items/add', [
                    'errors' => [$uploadResult['error']],
                    'old' => $old,
                ]);
                return;
            }

            $image = $uploadResult['filename'];
        }

        $saved = $this->itemService->addItem($userId, $title, $description, (float)$price,  $mode, $city, $image);

        if ($saved) {
            $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Item listed successfully.'];
            header("Location: /items");
        }

        $this->view('items/add', [
            'errors' => ['Failed to save item. Please try again.'],
            'old' => $old,
        ]);
    }

    public function myItems(): void
    {
        $userId = $_SESSION['user']['id'];
        $items = $this->itemService->getMyItems($userId);

        $message = '';
        if (isset($_GET['msg'])) {
            $messages = [
                'added' => 'Item listed successfully!',
                'updated' => 'Item updated successfully!',
                'deleted' => 'Item deleted.',
            ];
            $message = $messages[$_GET['msg']] ?? '';
        }

        $this->view('items/my_items', [
            'items' => $items,
            'message' => $message,
        ]);
    }

    public function browse(): void
    {
        $filters = [
            'search' => trim($_GET['search'] ?? ''),
            'city' => trim($_GET['city'] ?? ''),
            'mode' => trim($_GET['mode'] ?? ''),
        ];

        $items = $this->itemService->getMarketplaceItems($filters);

        $this->view('items/browse', [
            'items'   => $items,
            'filters' => $filters,
        ]);
    }

    public function showDetails(string $id): void
    {
        $itemId = (int)$id;
        $userId = $_SESSION['user']['id'];
        $item = $this->itemService->getMarketplaceItemWithSeller($itemId);

        if (!$item) {
            header("Location: /browse");
            exit;
        }

        $similarItems = $this->itemService->getSimilarItems($item['mode'], $itemId);
        $isOwner = (int)$item['user_id'] === (int)$userId;

        $this->view('items/details', [
            'item' => $item,
            'similarItems' => $similarItems,
            'isOwner' => $isOwner,
            'alreadySent' => false,
        ]);
    }

    public function showEdit(string $id): void
    {
        $itemId = (int)$id;
        $userId = $_SESSION['user']['id'];

        $item = $this->itemService->getItemById($itemId);

        if (!$item || (int)$item['user_id'] !== (int)$userId) {
            header("Location: /items");
            exit;
        }

        if (!$this->itemService->canEdit($itemId)) {
            header("Location: /items?error=cannot_edit");
            exit;
        }

        $this->view('items/edit', [
            'item' => $item,
            'errors' => [],
        ]);
    }

    public function edit(string $id): void
    {
        $itemId = (int)$id;
        $userId = $_SESSION['user']['id'];
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $mode = trim($_POST['mode'] ?? '');
        $city = trim($_POST['city'] ?? '');

        $item = $this->itemService->getItemById($itemId);

        if (!$item || (int)$item['user_id'] !== (int)$userId) {
            header("Location: /items");
            exit;
        }

        if (!$this->itemService->canEdit($itemId)) {
            header("Location: /items?error=cannot_edit");
            exit;
        }

        $validator = new ItemValidation();
        $errors = $validator->validate($title, $description, $price, $mode, $city);

        if (!empty($errors)) {
            $this->view('items/edit', ['item' => $item, 'errors' => $errors]);
            return;
        }

        $image = null;

        if (!empty($_FILES['image']['name'])) {
            $uploadResult = $this->handleImageUpload($_FILES['image']);

            if ($uploadResult['error']) {
                $this->view('items/edit', [
                    'item' => $item,
                    'errors' => [$uploadResult['error']],
                ]);
                return;
            }

            $image = $uploadResult['filename'];
        }

        $updated = $this->itemService->updateItem($itemId, $title, $description, (float)$price, $mode, $city, $image);

        if ($updated) {
            $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Item updated successfully.'];
            header("Location: /items");
        }

        $this->view('items/edit', [
            'item'   => $item,
            'errors' => ['Failed to update. Please try again.'],
        ]);
    }

    public function delete(string $id): void
    {
        $itemId = (int)$id;
        $userId = $_SESSION['user']['id'];

        $this->itemService->deleteItem($itemId, $userId);

        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Item deleted successfully.'];
        header("Location: /items");
        exit;
    }

    private function handleImageUpload(array $file): array
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        $maxSize = 2 * 1024 * 1024;

        if (!in_array($file['type'], $allowedTypes)) {
            return ['error' => 'Only JPG, PNG, WEBP images are allowed.'];
        }

        if ($file['size'] > $maxSize) {
            return ['error' => 'Image must be under 2MB.'];
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename   = uniqid('item_', true) . '.' . $extension;

        $uploadDir = __DIR__ . '/../../public/uploads/items/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            return ['error' => 'Failed to upload image. Try again.'];
        }

        return ['error' => null, 'filename' => $filename];
    }
}
