<?php 

namespace Vendor\App\Middleware;
class isGuest
{
    public function handle()
    {
        if(isset($_SESSION['user'])) {
            if (($_SESSION['user']['role'] ?? '') === 'admin') {
                header("Location: /admin/dashboard");
                exit;
            }
            header("Location: /dashboard");
            exit;
        }
    }
}