<?php

namespace Vendor\App\Controllers;

use Vendor\App\Core\Controller;
use Vendor\App\Services\DashboardService;
use Vendor\App\Services\ItemService;
use Vendor\App\Services\RequestService;
use Vendor\App\Core\Database;

class DashboardController extends Controller
{
    private DashboardService $dashboardService;
    private RequestService   $requestService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
        $this->requestService   = new RequestService();
    }

    public function index(): void
    {
        $userId      = $_SESSION['user']['id'];
        $summary     = $this->dashboardService->getSummary($userId);
        $recentItems = (new ItemService())->getMyItems($userId);

        $this->view('dashboard/index', [
            'user'        => $_SESSION['user'],
            'summary'     => $summary,
            'recentItems' => array_slice($recentItems, 0, 4),
        ]);
    }

    public function requests(): void
    {
        $userId = $_SESSION['user']['id'];
        $tab    = $_GET['tab'] ?? 'received';

        try {
            $incomingRequests = $this->requestService->getReceivedRequests($userId);
            $outgoingRequests = $this->requestService->getSentRequests($userId);
        } catch (\Throwable $e) {
            $incomingRequests = [];
            $outgoingRequests = [];
        }

        $this->view('dashboard/requests', [
            'incomingRequests' => $incomingRequests,
            'outgoingRequests' => $outgoingRequests,
            'tab'              => $tab,
        ]);
    }

    public function profile(): void
    {
        $userId  = $_SESSION['user']['id'];
        $summary = $this->dashboardService->getSummary($userId);

        $this->view('dashboard/profile', [
            'user'    => $_SESSION['user'],
            'summary' => $summary,
            'errors'  => [],
        ]);
    }

    public function updateProfile(): void
    {
        $userId = $_SESSION['user']['id'];
        $name   = trim($_POST['name']  ?? '');
        $phone  = trim($_POST['phone'] ?? '');
        $city   = trim($_POST['city']  ?? '');

        $errors = [];

        if (empty($name)) {
            $errors[] = 'Name is required.';
        }

        if (!empty($errors)) {
            $summary = $this->dashboardService->getSummary($userId);
            $this->view('dashboard/profile', [
                'user'    => $_SESSION['user'],
                'summary' => $summary,
                'errors'  => $errors,
            ]);
            return;
        }

        $db   = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare(
            "UPDATE users SET name = ?, phone = ?, city = ? WHERE id = ?"
        );
        $stmt->bind_param("sssi", $name, $phone, $city, $userId);
        $stmt->execute();

        // Update all relevant fields in session immediately
        $_SESSION['user']['name']  = $name;
        $_SESSION['user']['phone'] = $phone;
        $_SESSION['user']['city']  = $city;

        // Flash toast message
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Profile updated successfully.'];

        header("Location: /profile");
        exit;
    }
}
