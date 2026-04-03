<?php

namespace Vendor\App\Services;

use Vendor\App\Core\Database;

class RequestService
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function AlreadySentRequest(int $itemId, int $userId): bool
    {
        $stmt = $this->conn->prepare("SELECT id FROM requests WHERE item_id = ? AND requester_id = ? AND status NOT IN ('rejected', 'cancelled')");
        $stmt->bind_param("ii", $itemId, $userId);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function sendRequest(int $itemId, int $requesterId, int $ownerId): bool
    {
        $check = $this->conn->prepare("SELECT id FROM items WHERE id = ? AND status = 'active' AND deleted_at IS NULL");
        $check->bind_param("i", $itemId);
        $check->execute();

        if ($check->get_result()->num_rows === 0) {
            return false;
        }

        $stmt = $this->conn->prepare("INSERT INTO requests (item_id, requester_id, owner_id, status) VALUES (?, ?, ?, 'pending')");
        $stmt->bind_param("iii", $itemId, $requesterId, $ownerId);
        return $stmt->execute();
    }

    public function getReceivedRequests(int $userId): array
    {
        $stmt = $this->conn->prepare(
            "SELECT requests.*, items.title AS item_title, items.mode  AS item_mode, items.image AS item_image, users.name  AS requester_name FROM requests
             JOIN items ON requests.item_id = items.id JOIN users ON requests.requester_id = users.id
             WHERE requests.owner_id = ? ORDER BY requests.created_at DESC"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getSentRequests(int $userId): array
    {
        $stmt = $this->conn->prepare(
            "SELECT requests.*, items.title AS item_title,items.mode  AS item_mode,items.image AS item_image,users.name  AS owner_name FROM requests
             JOIN items ON requests.item_id = items.id JOIN users ON requests.owner_id = users.id
             WHERE requests.requester_id = ? ORDER BY requests.created_at DESC");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function approveRequest(int $requestId, int $ownerId): bool
    {
        $req = $this->getRequestById($requestId);

        if (!$req || $req['owner_id'] !== $ownerId) {
            return false;
        }

        $stmt = $this->conn->prepare("UPDATE requests SET status = 'approved' WHERE id = ?");
        $stmt->bind_param("i", $requestId);
        $stmt->execute();

        $item = $this->conn->prepare("UPDATE items SET status = 'reserved' WHERE id = ?");
        $item->bind_param("i", $req['item_id']);
        $item->execute();
        return true;
    }

    public function rejectRequest(int $requestId, int $ownerId): bool
    {
        $req = $this->getRequestById($requestId);

        if (!$req || $req['owner_id'] !== $ownerId) {
            return false;
        }

        $stmt = $this->conn->prepare("UPDATE requests SET status = 'rejected' WHERE id = ?");
        $stmt->bind_param("i", $requestId);
        return $stmt->execute();
    }

    public function markSold(int $requestId, int $ownerId): bool
    {
        $req = $this->getRequestById($requestId);

        if (!$req || $req['owner_id'] !== $ownerId) {
            return false;
        }

        $stmt = $this->conn->prepare("UPDATE requests SET status = 'completed' WHERE id = ?");
        $stmt->bind_param("i", $requestId);
        $stmt->execute();

        $item = $this->conn->prepare("UPDATE items SET status = 'sold' WHERE id = ?");
        $item->bind_param("i", $req['item_id']);
        return $item->execute();
    }

    public function markReturned(int $requestId, int $ownerId): bool
    {
        $req = $this->getRequestById($requestId);

        if (!$req || $req['owner_id'] !== $ownerId) {
            return false;
        }

        $item = $this->conn->prepare("UPDATE items SET status = 'returned' WHERE id = ?");
        $item->bind_param("i", $req['item_id']);
        return $item->execute();
    }

    public function cancelRequest(int $requestId, int $requesterId): bool
    {
        $req = $this->getRequestById($requestId);

        if (!$req || $req['requester_id'] !== $requesterId) {
            return false;
        }

        $stmt = $this->conn->prepare("UPDATE requests SET status = 'cancelled' WHERE id = ?");
        $stmt->bind_param("i", $requestId);
        $stmt->execute();

        if ($req['status'] === 'approved') {
            $item = $this->conn->prepare("UPDATE items SET status = 'active' WHERE id = ?");
            $item->bind_param("i", $req['item_id']);
            $item->execute();
        }

        return true;
    }

    private function getRequestById(int $requestId): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM requests WHERE id = ?");
        $stmt->bind_param("i", $requestId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ?: null;
    }
}
