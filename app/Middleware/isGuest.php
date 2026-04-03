<?php 

namespace Vendor\App\Middleware;
class isGuest
{
    public function handle()
    {
        if(isset($_SESSION['user'])) {
            header("Location: /dashboard");
            exit;
        }
    }
}