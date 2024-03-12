<?php

namespace Nebalus\Webapi\Collector;

use Nebalus\Webapi\Controller\DocsController;
use Nebalus\Webapi\Controller\HomeController;
use Nebalus\Webapi\Controller\Linktree\Api\LinktreeApiCreateController;
use Nebalus\Webapi\Controller\Linktree\Api\LinktreeApiDeleteController;
use Nebalus\Webapi\Controller\Linktree\Api\LinktreeApiReadController;
use Nebalus\Webapi\Controller\Linktree\Api\LinktreeApiUpdateController;
use Nebalus\Webapi\Controller\Linktree\LinktreeController;
use Nebalus\Webapi\Controller\Referral\Api\ReferralApiCreateController;
use Nebalus\Webapi\Controller\Referral\Api\ReferralApiDeleteController;
use Nebalus\Webapi\Controller\Referral\Api\ReferralApiReadController;
use Nebalus\Webapi\Controller\Referral\Api\ReferralApiUpdateController;
use Nebalus\Webapi\Controller\Referral\ReferralController;
use Nebalus\Webapi\Controller\TempController;
use Nebalus\Webapi\Handler\HttpNotFoundHandler;
use Nebalus\Webapi\Middleware\JsonValidatorMiddleware;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteCollectorProxy;

class RouteCollector
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function init(): void
    {
        $this->app->addRoutingMiddleware();

        $this->initErrorMiddleware();
        $this->initRoutes();
    }

    private function initErrorMiddleware(): void
    {
        // Definiert die ErrorMiddleware
        $isDevelopmentMode = (strtolower(getenv("APP_ENV")) === "development");
        $errorMiddleware = $this->app->addErrorMiddleware($isDevelopmentMode, true, true);

        if (true) {
            $errorMiddleware->setErrorHandler(HttpNotFoundException::class, HttpNotFoundHandler::class);
        }
    }

    private function initRoutes(): void
    {
        // Definiert die Route
        $this->app->group("/api", function (RouteCollectorProxy $group) {
            $group->get("/account", [TempController::class, "action"]);
            $group->group("/linktree", function (RouteCollectorProxy $group) {
                $group->post("/create", [LinktreeApiCreateController::class, "action"]);
                $group->get("/read", [LinktreeApiReadController::class, "action"]);
                $group->post("/update", [LinktreeApiUpdateController::class, "action"]);
                $group->delete("/delete", [LinktreeApiDeleteController::class, "action"]);
            });
            $group->group("/referral", function (RouteCollectorProxy $group) {
                $group->post("/create", [ReferralApiCreateController::class, "action"]);
                $group->get("/read", [ReferralApiReadController::class, "action"]);
                $group->post("/update", [ReferralApiUpdateController::class, "action"]);
                $group->delete("/delete", [ReferralApiDeleteController::class, "action"]);
            });
            $group->group("/game", function (RouteCollectorProxy $group) {
                $group->group("/cosmoventure", function (RouteCollectorProxy $group) {
                    $group->get("/version", [TempController::class, "action"]);
                });
            });
        })->add(JsonValidatorMiddleware::class);

        $this->app->group("/u", function (RouteCollectorProxy $group) {
            $group->get("/{username}", [TempController::class, "action"]);
        });

        $this->app->group("/account", function (RouteCollectorProxy $group) {
            $group->get("/register", [TempController::class, "action"]);
            $group->get("/login", [TempController::class, "action"]);
            $group->get("/dashboard", [TempController::class, "action"]);
        });

        $this->app->group("/terms", function (RouteCollectorProxy $group) {
            $group->get("/privacy", [TempController::class, "action"]);
        });

        $this->app->group("/projects", function (RouteCollectorProxy $group) {
            $group->get("/mandelbrot", [TempController::class, "action"]);
            $group->get("/oriri", [TempController::class, "action"]);
            $group->get("/cosmoventure", [TempController::class, "action"]);
            $group->get("/melody", [TempController::class, "action"]);
        });

        $this->app->get("/", [HomeController::class, "action"]);
        $this->app->get("/docs", [DocsController::class, "action"]);
        $this->app->get("/linktree", [LinktreeController::class, "action"]);
        $this->app->get("/ref", [ReferralController::class, "action"]);
    }
}
