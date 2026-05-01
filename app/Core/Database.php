<?php 
namespace Vendor\App\Core;

use mysqli;

class Database 
{
    public function getConnection()
    {
        $config = require __DIR__ . '/../../config/database.php';
        $conn = new mysqli(
            $config['host'],
            $config['user'],
            $config['pass'],
            $config['dbname'],
            $config['port'],
        );

        if($conn->connect_error) {
            die("database Connection Failed:" . $conn->connect_error);
        }
        return $conn;
    }
}
