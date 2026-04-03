<?php

namespace Vendor\App\Controllers;

use Vendor\App\Core\Controller;
use Vendor\App\Services\RequestService;
use Vendor\App\Services\BrowseService;

class RequestController extends Controller
{
    private RequestService $requestService;
    private BrowseService  $browseService;

    public function __construct(RequestService $requestService, BrowseService $browseService)
    {
        $this->requestService = $requestService;
        $this->browseService  = $browseService;
    }
    public function send(): void
    {
        $userId  = $_SESSION['user']['id'];
        $itemId  = (int)($_POST['item_id']  ?? 0);
        $ownerId = (int)($_POST['owner_id'] ?? 0);

        if ($ownerId === $userId) {
            header("Location: /items/view/{$itemId}");
            exit;
        }

        if ($this->requestService->AlreadySentRequest($itemId, $userId)) {
            header("Location: /items/view/{$itemId}?error=already_sent");
            exit;
        }

        $sent = $this->requestService->sendRequest($itemId, $userId, $ownerId);

        if ($sent) {
            header("Location: /items/view/{$itemId}?success=request_sent");
        } else {
            header("Location: /items/view/{$itemId}?error=unavailable");
        }
        exit;
    }

    public function approve(string $id): void
    {
        $requestId = (int)$id;
        $userId    = $_SESSION['user']['id'];

        $this->requestService->approveRequest($requestId, $userId);

        header("Location: /requests?tab=received&msg=approved");
        exit;
    }

    public function reject(string $id): void
    {
        $requestId = (int)$id;
        $userId    = $_SESSION['user']['id'];

        $this->requestService->rejectRequest($requestId, $userId);

        header("Location: /requests?tab=received&msg=rejected");
        exit;
    }

    public function markSold(string $id): void
    {
        $requestId = (int)$id;
        $userId    = $_SESSION['user']['id'];

        $this->requestService->markSold($requestId, $userId);

        header("Location: /requests?tab=received&msg=sold");
        exit;
    }

    public function markReturned(string $id): void
    {
        $requestId = (int)$id;
        $userId    = $_SESSION['user']['id'];

        $this->requestService->markReturned($requestId, $userId);

        header("Location: /requests?tab=received&msg=returned");
        exit;
    }

    public function cancel(string $id): void
    {
        $requestId = (int)$id;
        $userId    = $_SESSION['user']['id'];

        $this->requestService->cancelRequest($requestId, $userId);

        header("Location: /requests?tab=sent&msg=cancelled");
        exit;
    }
}
