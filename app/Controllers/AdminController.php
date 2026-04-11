<?php

namespace Vendor\App\Controllers;

use Vendor\App\Core\Controller;
use Vendor\App\Services\AdminService;
use Exception;

class AdminController extends Controller
{
    private AdminService $adminService;
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index()
    {
        $stats = $this->adminService->getStats();
        $this->view('admin/dashboard', ['stats' => $stats, 'users' => []]);
    }

    public function users()
    {
        try {
            $stats = $this->adminService->getStats();
            $users = $this->adminService->getAllUsers();
            $this->view('admin/dashboard', ['stats' => $stats, 'users' => $users]);
        } catch (Exception $e) {
            $this->log($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine()]);
            $_SESSION['error'] = "Something Went Wrong";
            $this->view('admin/dashboard', ['stats' => [], 'users' => []]);
        }
    }
    
    public function items()
    {
        try {
            $items = $this->adminService->getAllItems();
            $this->view('admin/items', ['items' => $items]);
        } catch (Exception $e) {
            $this->log($e->getMessage(), ['file' => $e->getFile(), 'Line' => $e->getLine()]);
            $_SESSION['error'] = 'Something went wrong';
            $this->view('admin/items', ['items' => []]);
        }
    }

    public function deleteUser(string $id)
    {
        try {
            $userId = (int)$id;
            $this->adminService->deleteUser($userId);
            header("Location: /admin/users");
        } catch (Exception $e) {
            $this->log($e->getMessage(), ['file' => $e->getFile(), 'Line' => $e->getLine()]);
            $_SESSION['error'] = "Something went Wrong";
            header("Location: /admin/users");
        }
    }

    public function deleteItem(string $id)
    {
        try {
            $itemId = (int)$id;
            $this->adminService->deleteItem($itemId);
            header('Location: /admin/items');
        } catch (Exception $e) {
            $this->log($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine()]);
            $_SESSION['error'] = "Something went wrong";
            header("Location: /admin/items");
        }
    }

    public function showEditUser(string $id): void
    {
        try {
            $user = $this->adminService->getUserById((int)$id);
            if (!$user) {
                header("Location: /admin/dashboard");
                exit;
            }
            $this->view('admin/users/edit', ['user' => $user, 'errors' => []]);
        } catch (Exception $e) {
            $this->log($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine()]);
            $_SESSION['error'] = "Something went wrong";
            header("Location: /admin/dashboard");
        }
    }


    public function editUser(string $id)
    {
        try {
            $userId = (int)$id;
            $name = trim($_POST['name']  ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $city = trim($_POST['city']  ?? '');

            $this->adminService->editUser($userId, $name, $phone, $city);
            $_SESSION['flash'] = ['type' => 'success', 'msg' => 'User updated successfully.'];
            header("Location: /admin/dashboard");
            exit;
        } catch (Exception $e) {
            $this->log($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine()]);
            $_SESSION['error'] = "Something went wrong";
            header("Location: /admin/dashboard");
        }
    }
}
