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
}
