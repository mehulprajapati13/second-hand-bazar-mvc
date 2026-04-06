<?php

namespace Vendor\App\Services;

use Vendor\App\Core\Database;

class DashboardService
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getSummary(int $userId): array
    {
        return [
            'total_items' => $this->countItems($userId),
            'active_items' => $this->countItemsByStatus($userId, 'active'),
            'reserved_items' => $this->countItemsByStatus($userId, 'reserved'),
            'sold_items' => $this->countItemsByStatus($userId, 'sold'),
            'requests_received' => $this->countRequestsReceived($userId),
            'requests_sent' => $this->countRequestsSent($userId),
        ];
    }

    private function countItems(int $userId): int
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM items WHERE user_id = ? AND deleted_at IS NULL");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return (int) $row['total'];
    }

    private function countItemsByStatus(int $userId, string $status): int
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM items WHERE user_id = ? AND status = ? AND deleted_at IS NULL");
        $stmt->bind_param("is", $userId, $status);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return (int) $row['total'];
    }

    private function countRequestsReceived(int $userId): int
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM requests WHERE owner_id = ? AND status = 'pending' ");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return (int)($row['total'] ?? 0);
    }

    private function countRequestsSent(int $userId): int
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM requests WHERE requester_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return (int)($row['total'] ?? 0);
    }

    public function updateProfile(int $userId, string $name, string $phone, string $city): bool
    {
        $stmt = $this->conn->prepare("UPDATE users SET name = ?, phone = ?, city = ? WHERE id = ?" );
        $stmt->bind_param("sssi", $name, $phone, $city, $userId);
        return $stmt->execute();
    }
}
