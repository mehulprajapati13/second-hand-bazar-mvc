<?php 

namespace Vendor\App\Middleware;

class isAuth 
{
    public function handle()
    {
        if(!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }
    }
}