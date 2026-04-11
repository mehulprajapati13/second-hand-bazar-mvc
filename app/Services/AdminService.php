<?php

namespace Vendor\App\Services;

use Vendor\App\Core\Database;

class AdminService
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getStats()
    {
        return [
            'total_users' => $this->count("SELECT COUNT(*) as total FROM users WHERE deleted_at IS NULL AND role!= 'admin'"),
            'total_items' => $this->count("SELECT COUNT(*) as total FROM items WHERE deleted_at IS NULL"),
            'active_items' => $this->count("SELECT COUNT(*) as total FROM items WHERE status = 'active' AND deleted_at iS NULL"),
            'sold_items' => $this->count("SELECT COUNT(*) AS total FROM items WHERE status = 'sold' "),
        ];
    }

    private function count(string $sql)
    {
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return (int)($row['total'] ?? 0);
    }

    public function getAllUsers()
    {
        $stmt = $this->conn->prepare("SELECT id, name, email, phone, city, is_verified, created_at  FROM users WHERE role != 'admin' && deleted_at IS NULL 
                ORDER BY created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    public function getAllItems()
    {
        $stmt = $this->conn->prepare("SELECT items.* , users.name as seller_name , users.email as seller_email
                FROM items JOIN users 
                ON users.id = items.user_id
                WHERE items.deleted_at IS NULL
                ORDER BY created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    public function getUserById(int $userId): ?array
    {
        $stmt = $this->conn->prepare("SELECT id, name, email, phone, city FROM users WHERE id = ? AND deleted_at IS NULL");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ?: null;
    }

    public function deleteUser(int $userId)
    {
        $stmt = $this->conn->prepare("UPDATE users SET deleted_at = NOW() WHERE id = ?");
        $stmt->bind_param('i', $userId);
        return $stmt->execute();
    }

    public function deleteItem(int $itemId)
    {
        $stmt = $this->conn->prepare("UPDATE items SET deleted_at = NOW() WHERE id = ?");
        $stmt->bind_param('i', $itemId);
        return $stmt->execute();
    }

    public function editUser(int $userId, string $name, string $phone, string $city)
    {
        $stmt = $this->conn->prepare("UPDATE users SET name = ?, phone = ?, city = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $phone, $city, $userId);
        return $stmt->execute();
    }
}
