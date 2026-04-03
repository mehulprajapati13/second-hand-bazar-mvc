<?php

namespace Vendor\App\Services;  

use Vendor\App\Core\Database;

class BrowseService
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getItems(int $userId, string $mode = '', string $city = ''): array
    {
        $sql = "SELECT items.*, users.name AS seller_name FROM items JOIN users ON items.user_id = users.id
                WHERE items.user_id != ? AND items.status = 'active' AND items.deleted_at IS NULL";

        $params = [$userId];
        $types = "i";

        if (!empty($mode)) {
            $sql .= " AND items.mode = ?";
            $params[] = $mode;
            $types .= "s";
        }

        if (!empty($city)) {
            $sql .= " AND items.city LIKE ?";
            $params[] = "%" . $city . "%";
            $types .= "s";
        }

        $sql .= " ORDER BY items.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getItemDetail(int $itemId): ?array
    {
        $stmt = $this->conn->prepare("SELECT items.*, users.name AS seller_name, users.city AS seller_city FROM items
                JOIN users ON items.user_id = users.id WHERE items.id = ? AND items.deleted_at IS NULL");  
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ?: null;
    }
}