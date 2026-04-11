<?php

namespace Vendor\App\Middleware;

class isAdmin
{
    public function handle()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        if (($_SESSION['user']['role'] ?? '') !== 'admin') {
            header("Location: /dashboard");
            exit;
        }
    }
}
