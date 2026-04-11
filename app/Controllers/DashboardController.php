<?php

namespace Vendor\App\Controllers;

use Vendor\App\Core\Controller;
use Vendor\App\Services\DashboardService;
use Vendor\App\Services\ItemService;
use Vendor\App\Services\RequestService;
class DashboardController extends Controller
{
    private DashboardService $dashboardService;
    private ItemService $itemService;
    private RequestService $requestService;
    public function __construct(DashboardService $dashboardService,ItemService $itemService,RequestService $requestService)
    {
        $this->dashboardService = $dashboardService;
        $this->itemService = $itemService;
        $this->requestService =  new RequestService();
    }

    public function index(): void
    {
        $userId = $_SESSION['user']['id'];
        $summary = $this->dashboardService->getSummary($userId);
        $recentItems = $this->itemService->getMyItems($userId);

        $this->view('dashboard/index', [
            'user' => $_SESSION['user'],
            'summary' => $summary,
            'recentItems' => array_slice($recentItems, 0, 4),
        ]);
    }

    public function profile(): void
    {
        $userId = $_SESSION['user']['id'];
        $summary = $this->dashboardService->getSummary($userId);

        $this->view('dashboard/profile', [
            'user' => $_SESSION['user'],
            'summary' => $summary,
            'errors' => [],
        ]);
    }

    public function updateProfile(): void
    {
        $userId = $_SESSION['user']['id'];
        $name = trim($_POST['name']  ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $city = trim($_POST['city']  ?? '');

        $errors = [];

        if (empty($name)) {
            $errors[] = 'Name is required.';
        }

        if (!empty($errors)) {
            $summary = $this->dashboardService->getSummary($userId);
            $this->view('dashboard/profile', [
                'user' => $_SESSION['user'],
                'summary' => $summary,
                'errors' => $errors,
            ]);
            return;
        }

        $this->dashboardService->updateProfile($userId, $name, $phone, $city);

        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['phone'] = $phone;
        $_SESSION['user']['city'] = $city;

        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Profile updated successfully.'];
    
        header("Location: /profile");
        exit;
    }

    public function requests()
    {
        $userId = (int)$_SESSION['user']['id'];
        $tab = $_GET['tab'] ?? 'received';

        $received = $this->requestService->getReceivedRequests($userId);
        $sent = $this->requestService->getSentRequests($userId);

        $this->view('dashboard/requests', [
            'received' => $received,
            'sent' => $sent,
            'tab' => $tab,
        ]);
    }
}
