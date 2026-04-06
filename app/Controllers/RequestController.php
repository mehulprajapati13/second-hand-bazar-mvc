<?php

namespace Vendor\App\Controllers;

use Vendor\App\Core\Controller;
use Vendor\App\Services\RequestService;
use Vendor\App\Services\BrowseService;

class RequestController extends Controller
{
    private RequestService $requestService;

    public function __construct(RequestService $requestService)
    {
        $this->requestService = $requestService;
    }
}
