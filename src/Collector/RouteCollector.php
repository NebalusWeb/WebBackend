<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Collector;

use Nebalus\Webapi\Action\Referral\ReferralCreateAction;
use Nebalus\Webapi\Action\Referral\ReferralDeleteAction;
use Nebalus\Webapi\Action\Referral\ReferralEditAction;
use Nebalus\Webapi\Action\Referral\ReferralGetAction;
use Nebalus\Webapi\Action\TempAction;
use Nebalus\Webapi\Action\User\UserCreateAction;
use Nebalus\Webapi\Action\AuthAction;
use Nebalus\Webapi\Handler\ErrorHandler;
use Nebalus\Webapi\Middleware\AuthMiddleware;
use Nebalus\Webapi\Middleware\CorsMiddleware;
use Nebalus\Webapi\Option\EnvData;
use Slim\App;
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
        $this->initErrorMiddleware();
        $this->app->add(CorsMiddleware::class);
        $this->initRoutes();
    }

    private function initErrorMiddleware(): void
    {
        $errorMiddleware = $this->app->addErrorMiddleware($this->env->isDevelopment(), true, true);

//        if ($this->env->isProduction()) {
            $errorMiddleware->setDefaultErrorHandler(ErrorHandler::class);
//        }
    }

    private function initRoutes(): void
    {
        $this->app->group("/user", function (RouteCollectorProxy $group) {
            $group->map(["POST"], "/auth", [AuthAction::class, "action"]);
            $group->group("/{username}", function (RouteCollectorProxy $group) {
                $group->map(["GET"], "", [TempAction::class, "action"])->add(AuthMiddleware::class);
                $group->map(["PATCH"], "", [TempAction::class, "action"])->add(AuthMiddleware::class);
                $group->map(["DELETE"], "", [TempAction::class, "action"])->add(AuthMiddleware::class);
                $group->map(["POST"], "", [UserCreateAction::class, "entryAction"])->add(AuthMiddleware::class);
                $group->group("/linktree", function (RouteCollectorProxy $group) {
                    $group->map(["GET"], "", [TempAction::class, "action"]);
                    $group->map(["PATCH"], "/update", [TempAction::class, "action"])->add(AuthMiddleware::class);
                });
            });
        });

        $this->app->group("/referrals/[{code}]", function (RouteCollectorProxy $group) {
            $group->map(["GET"], "", [ReferralGetAction::class, "action"]);
            $group->map(["POST"], "", [ReferralCreateAction::class, "action"])->add(AuthMiddleware::class);
            $group->map(["PATCH"], "", [ReferralEditAction::class, "action"])->add(AuthMiddleware::class);
            $group->map(["DELETE"], "", [ReferralDeleteAction::class, "action"])->add(AuthMiddleware::class);
        });

        $this->app->group("/analytics", function (RouteCollectorProxy $group) {
            $group->group("/signatures", function (RouteCollectorProxy $group) {
                $group->map(["GET"], "", [TempAction::class, "action"]);
            });
            $group->group("/services/[{id}]", function (RouteCollectorProxy $group) {
            });
            $group->group("/charts/[{id}]", function (RouteCollectorProxy $group) {
            });
        });

        $this->app->group("/projects", function (RouteCollectorProxy $group) {
            $group->group("/cosmoventure", function (RouteCollectorProxy $group) {
                $group->get("/version", [TempAction::class, "action"]);
            });
        });
    }
}
