<?php

namespace Vendor\App\Services;

use Vendor\App\Core\Database;

class ItemService
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function addItem(int $userId, string $title, string $description, float  $price, string $mode, string $city, ?string $image): bool
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO items
            (user_id, title, description, price, mode, city, image, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'active')"
        );

        $stmt->bind_param("issdsss", $userId, $title, $description, $price, $mode, $city, $image);
        return $stmt->execute();
    }

    public function getMyItems(int $userId): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM items WHERE user_id = ? AND deleted_at IS NULL ORDER BY created_at DESC");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getItemById(int $itemId): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM items WHERE id = ? AND deleted_at IS NULL");
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ?: null;
    }

    public function canEdit(int $itemId): bool
    {
        $item = $this->getItemById($itemId);

        if (!$item || $item['status'] !== 'active') {
            return false;
        }

        // Request module is optional right now; allow editing when request data is unavailable.
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM requests WHERE item_id = ? AND status IN ('pending', 'approved')");
            $stmt->bind_param("i", $itemId);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();

            return (int)($row['total'] ?? 0) === 0;
        } catch (\Throwable $e) {
            return true;
        }
    }

    public function updateItem(int $itemId, string $title, string $description, float  $price, string $mode, string $city, ?string $image): bool
    {
        if ($image === null) {
            $stmt = $this->conn->prepare( "UPDATE items SET title = ?, description = ?, price = ?, mode = ?, city = ? WHERE id = ?");
            $stmt->bind_param("ssdssi", $title, $description, $price, $mode, $city, $itemId);
        } else {
            $stmt = $this->conn->prepare(
                "UPDATE items SET title = ?, description = ?, price = ?, mode = ?, city = ?, image = ? WHERE id = ?");
            $stmt->bind_param("ssdsssi", $title, $description, $price, $mode, $city, $image, $itemId);
        }

        return $stmt->execute();
    }

    public function deleteItem(int $itemId, int $userId): bool
    {
        $stmt = $this->conn->prepare("UPDATE items SET deleted_at = NOW() WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $itemId, $userId);
        return $stmt->execute();
    }

    public function getMarketplaceItems(array $filters = []): array
    {
        $conditions = ["items.deleted_at IS NULL", "items.status IN ('active','reserved')"];
        $types = '';
        $params = [];

        if (!empty($filters['search'])) {
            $conditions[] = "items.title LIKE ?";
            $types .= 's';
            $params[] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['city'])) {
            $conditions[] = "items.city LIKE ?";
            $types .= 's';
            $params[] = '%' . $filters['city'] . '%';
        }

        if (!empty($filters['mode']) && in_array($filters['mode'], ['sell', 'rent'])) {
            $conditions[] = "items.mode = ?";
            $types .= 's';
            $params[] = $filters['mode'];
        }

        $where = implode(' AND ', $conditions);

        $sql = "SELECT items.*, users.name AS seller_name, users.city AS seller_city
                FROM items
                JOIN users ON users.id = items.user_id
                WHERE $where
                ORDER BY items.created_at DESC";

        $stmt = $this->conn->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getMarketplaceItemWithSeller(int $itemId): ?array
    {
        $stmt = $this->conn->prepare(
            "SELECT items.*, users.name AS seller_name, users.city AS seller_city,
                    users.phone AS seller_phone, users.email AS seller_email
             FROM items
             JOIN users ON users.id = items.user_id
             WHERE items.id = ? AND items.deleted_at IS NULL"
        );

        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ?: null;
    }

    public function getSimilarItems(string $mode, int $excludeId, int $limit = 4): array
    {
        $stmt = $this->conn->prepare(
            "SELECT items.*, users.name AS seller_name, users.city AS seller_city
             FROM items
             JOIN users ON users.id = items.user_id
             WHERE items.deleted_at IS NULL
               AND items.status = 'active'
               AND items.mode = ?
               AND items.id <> ?
             ORDER BY items.created_at DESC
             LIMIT ?"
        );

        $stmt->bind_param("sii", $mode, $excludeId, $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
