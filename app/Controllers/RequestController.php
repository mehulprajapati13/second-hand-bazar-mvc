<?php

namespace Vendor\App\Controllers;

use Vendor\App\Core\Controller;
use Vendor\App\Services\RequestService;


class RequestController extends Controller
{
    private RequestService $requestService;

    public function __construct(RequestService $requestService)
    {
        $this->requestService = $requestService;
    }

    public function send()
    {
        $userId = (int)$_SESSION['user']['id'];
        $itemId = (int)($_POST['item_id']  ?? 0);
        $ownerId = (int)($_POST['owner_id'] ?? 0);

        if ($ownerId == $userId) {
            header("Location: /item/view/{$itemId}");
            exit;
        }

        if ($this->requestService->alreadySentRequest($itemId, $userId)) {
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

    public function approve(string $id)
    {
        $this->requestService->approveRequest((int)$id, (int)$_SESSION['user']['id']);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Request approved, Item is now reserved'];
        header("Location: /requests?tab=received");
        exit;
    }

    public function reject(string $id)
    {
        $this->requestService->rejectRequest((int)$id, (int)$_SESSION['user']['id']);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Request rejected'];
        header("Location: /requests?tab=received");
        exit;
    }

    public function markSold(string $id)
    {
        $this->requestService->markSold((int)$id, (int)$_SESSION['user']['id']);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Item marked as sold'];
        header("Location: /requests?tab=received");
        exit;
    }

    public function markReturned(string $id)
    {
        $this->requestService->markReturned((int)$id, (int)$_SESSION['user']['id']);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => "Item marked as returned"];
        header("Location: /requests?tab=received");
        exit;
    }

    public function cancel(string $id)
    {
        $this->requestService->cancelRequest((int)$id, (int)$_SESSION['user']['id']);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Request Cancelled'];
        header("Location: /requests?tab=sent");
        exit;
    }
}
