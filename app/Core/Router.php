<?php

namespace Vendor\App\Core;

use Vendor\App\Controllers\AuthController;
use Vendor\App\Controllers\BrowseController;
use Vendor\App\Controllers\DashboardController;
use Vendor\App\Controllers\ItemController;
use Vendor\App\Controllers\RequestController;
use Vendor\App\Services\AuthService;
use Vendor\App\Services\DashboardService;
use Vendor\App\Services\ItemService;
use Vendor\App\Services\BrowseService;
use Vendor\App\Services\RequestService;

class Router
{
    private array $routes = [];
    private ?string $currentMiddleware = null;

    public function middleware(string $middleware): static
    {
        $this->currentMiddleware = $middleware;
        return $this;
    }

    public function get(string $uri, string $action): void
    {
        $this->routes['GET'][] = [
            'uri'        => $uri,
            'action'     => $action,
            'middleware' => $this->currentMiddleware,
        ];
        $this->currentMiddleware = null;
    }

    public function post(string $uri, string $action): void
    {
        $this->routes['POST'][] = [
            'uri'        => $uri,
            'action'     => $action,
            'middleware' => $this->currentMiddleware,
        ];
        $this->currentMiddleware = null;
    }

    public function dispatch(string $uri, string $method): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptDir !== '/' && str_starts_with($uri, $scriptDir)) {
            $uri = substr($uri, strlen($scriptDir));
        }

        if (empty($uri)) {
            $uri = '/';
        }

        $matchedRoute = null;
        $params       = [];

        foreach ($this->routes[$method] ?? [] as $route) {
            $pattern = preg_replace('/\{[a-zA-Z]+\}/', '([^/]+)', $route['uri']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                $params       = $matches;
                $matchedRoute = $route;
                break;
            }
        }

        if (!$matchedRoute) {
            http_response_code(404);
            echo "<h1>404 — Page Not Found</h1>";
            return;
        }

        if (!empty($matchedRoute['middleware'])) {
            $middlewareClass = "Vendor\\App\\Middleware\\{$matchedRoute['middleware']}";
            (new $middlewareClass)->handle();
        }

        [$controllerName, $methodName] = explode('@', $matchedRoute['action']);
        $controllerClass = "Vendor\\App\\Controllers\\$controllerName";

        $this->resolveController($controllerClass)->$methodName(...$params);
    }

    private function resolveController(string $controllerClass): object
    {
        $authService = new AuthService();
        $dashboardService = new DashboardService();
        $itemService = new ItemService();
        $browseService = new BrowseService();
        $requestService = new RequestService();

        return match ($controllerClass) {
            AuthController::class =>
                new AuthController($authService),

            DashboardController::class =>
                new DashboardController($dashboardService, $itemService),

            ItemController::class =>
                new ItemController($itemService),

            BrowseController::class =>
                new BrowseController($browseService, $requestService),

            RequestController::class =>
                new RequestController($requestService),

            default => new $controllerClass()
        };
    }
}