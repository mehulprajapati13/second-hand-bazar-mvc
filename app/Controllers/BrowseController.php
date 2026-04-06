<?php

namespace Vendor\App\Controllers;

use Vendor\App\Core\Controller;
use Vendor\App\Services\BrowseService;
use Vendor\App\Services\RequestService;

class BrowseController extends Controller
{
    private BrowseService $browseService;
    private RequestService $requestService;

    public function __construct(BrowseService $browseService, RequestService $requestService)
    {
        $this->browseService = $browseService;
        $this->requestService = $requestService;
    }

    public function index(): void
    {
        $userId = $_SESSION['user']['id'];
        $mode = trim($_GET['mode'] ?? '');
        $city = trim($_GET['city'] ?? '');

        $items = $this->browseService->getItems($userId, $mode, $city);

        $this->view('browse/index', [
            'items' => $items,
            'filterMode' => $mode,
            'filterCity' => $city,
        ]);
    }

    public function detail(string $id): void
    {
        $itemId = (int)$id;
        $userId = $_SESSION['user']['id'];

        $item = $this->browseService->getItemDetail($itemId);

        if (!$item) {
            header("Location: /browse");
            exit;
        }

        $isOwner = (int)$item['user_id'] === (int)$userId;

        $this->view('browse/detail', [
            'item'        => $item,
            'isOwner'     => $isOwner,
        ]);
    }
}