<?php

namespace Nebalus\Webapi\Collector;

use Nebalus\Webapi\Controller\Linktree\LinktreeApiCreateController;
use Nebalus\Webapi\Controller\Linktree\LinktreeApiDeleteController;
use Nebalus\Webapi\Controller\Linktree\LinktreeApiReadController;
use Nebalus\Webapi\Controller\Linktree\LinktreeApiUpdateController;
use Nebalus\Webapi\Controller\Referral\ReferralApiCreateController;
use Nebalus\Webapi\Controller\Referral\ReferralApiDeleteController;
use Nebalus\Webapi\Controller\Referral\ReferralApiReadController;
use Nebalus\Webapi\Controller\Referral\ReferralApiUpdateController;
use Nebalus\Webapi\Controller\TempController;
use Nebalus\Webapi\Handler\HttpNotFoundHandler;
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
        $this->app->get("/users", [TempController::class, "action"]);
        $this->app->group("/linktree", function (RouteCollectorProxy $group) {
            $group->post("/create", [LinktreeApiCreateController::class, "action"]);
            $group->get("/read", [LinktreeApiReadController::class, "action"]);
            $group->post("/update", [LinktreeApiUpdateController::class, "action"]);
            $group->delete("/delete", [LinktreeApiDeleteController::class, "action"]);
        });
        $this->app->group("/referral", function (RouteCollectorProxy $group) {
            $group->post("/create", [ReferralApiCreateController::class, "action"]);
            $group->get("/read", [ReferralApiReadController::class, "action"]);
            $group->post("/update", [ReferralApiUpdateController::class, "action"]);
            $group->delete("/delete", [ReferralApiDeleteController::class, "action"]);
        });
        $this->app->group("/games", function (RouteCollectorProxy $group) {
            $group->group("/cosmoventure", function (RouteCollectorProxy $group) {
                $group->get("/version", [TempController::class, "action"]);
            });
        });
    }
}
