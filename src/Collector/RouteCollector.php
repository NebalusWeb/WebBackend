<?php

namespace Nebalus\Webapi\Collector;

use Nebalus\Webapi\Controller\Account\AccountLoginController;
use Nebalus\Webapi\Controller\Linktree\LinktreeCreateController;
use Nebalus\Webapi\Controller\Linktree\LinktreeDeleteController;
use Nebalus\Webapi\Controller\Linktree\LinktreeReadController;
use Nebalus\Webapi\Controller\Linktree\LinktreeUpdateController;
use Nebalus\Webapi\Controller\Referral\ReferralCreateController;
use Nebalus\Webapi\Controller\Referral\ReferralDeleteController;
use Nebalus\Webapi\Controller\Referral\ReferralGetController;
use Nebalus\Webapi\Controller\Referral\ReferralUpdateController;
use Nebalus\Webapi\Controller\TempController;
use Nebalus\Webapi\Handler\DefaultErrorHandler;
use Nebalus\Webapi\Middleware\JwtAuthMiddleware;
use Nebalus\Webapi\Option\EnvData;
use Slim\App;
use Slim\Exception\HttpException;
use Slim\Routing\RouteCollectorProxy;

class RouteCollector
{
    private App $app;
    private EnvData $env;

    public function __construct(App $app, EnvData $env)
    {
        $this->app = $app;
        $this->env = $env;
    }

    public function init(): void
    {
        $this->app->addRoutingMiddleware();

        $this->initRoutes();
        $this->initErrorMiddleware();
    }

    private function initErrorMiddleware(): void
    {
        $errorMiddleware = $this->app->addErrorMiddleware($this->env->isDevelopment(), true, true);

        if ($this->env->isProduction() || true) {
            $errorMiddleware->setDefaultErrorHandler(DefaultErrorHandler::class);
        }
    }

    private function initRoutes(): void
    {
        // Definiert die Route
        $this->app->group("/user", function (RouteCollectorProxy $group) {
            $group->post("/login", [AccountLoginController::class, "action"]);
            $group->post("/register", [TempController::class, "action"]);
        });

        $this->app->group("/linktree", function (RouteCollectorProxy $group) {
            $group->post("/create", [LinktreeCreateController::class, "action"])->add(JwtAuthMiddleware::class);
            $group->get("/read", [LinktreeReadController::class, "action"]);
            $group->post("/update", [LinktreeUpdateController::class, "action"])->add(JwtAuthMiddleware::class);
            $group->delete("/delete", [LinktreeDeleteController::class, "action"])->add(JwtAuthMiddleware::class);
        });

        $this->app->group("/referral", function (RouteCollectorProxy $group) {
            $group->map(["GET"], "/get/[{code}]", [ReferralGetController::class, "action"]);
            $group->map(["PUT"], "/create", [ReferralCreateController::class, "action"])->add(JwtAuthMiddleware::class);
            $group->map(["POST"], "/update", [ReferralUpdateController::class, "action"])->add(JwtAuthMiddleware::class);
            $group->map(["DELETE"], "/delete", [ReferralDeleteController::class, "action"])->add(JwtAuthMiddleware::class);
        });
        $this->app->group("/games", function (RouteCollectorProxy $group) {
            $group->group("/cosmoventure", function (RouteCollectorProxy $group) {
                $group->get("/version", [TempController::class, "action"]);
            });
        });
    }
}
