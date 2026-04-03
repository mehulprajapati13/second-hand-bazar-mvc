<?php 

namespace Vendor\App\Models;

use Vendor\App\Core\Database;

class User 
{
    public $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
}