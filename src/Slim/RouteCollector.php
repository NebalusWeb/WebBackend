<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Slim;

use Nebalus\Webapi\Api\Action\Referral\LinktreeClickAction;
use Nebalus\Webapi\Api\Action\Referral\LinktreeDeleteAction;
use Nebalus\Webapi\Api\Action\Referral\LinktreeEditAction;
use Nebalus\Webapi\Api\Action\Referral\LinktreeGetAction;
use Nebalus\Webapi\Api\Action\Referral\ReferralClickAction;
use Nebalus\Webapi\Api\Action\Referral\ReferralCreateAction;
use Nebalus\Webapi\Api\Action\Referral\ReferralDeleteAction;
use Nebalus\Webapi\Api\Action\Referral\ReferralEditAction;
use Nebalus\Webapi\Api\Action\Referral\ReferralGetAction;
use Nebalus\Webapi\Api\Action\User\UserAuthAction;
use Nebalus\Webapi\Option\EnvData;
use Nebalus\Webapi\Slim\Middleware\AuthMiddleware;
use Nebalus\Webapi\Slim\Middleware\CorsMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

readonly class RouteCollector
{
    public function __construct(
        private App $app,
        private EnvData $env
    ) {
    }

    public function init(): void
    {
        $this->app->addRoutingMiddleware();
        $this->app->addBodyParsingMiddleware();
        $this->app->add(CorsMiddleware::class);
        $this->initErrorMiddleware();
        $this->initRoutes();
    }

    private function initErrorMiddleware(): void
    {
        $errorMiddleware = $this->app->addErrorMiddleware($this->env->isDevelopment(), true, true);
    }

    private function initRoutes(): void
    {
        $this->app->group("/ui", function (RouteCollectorProxy $group) {
            $group->map(["POST"], "/auth", UserAuthAction::class);
            $group->group("/user/{username}", function (RouteCollectorProxy $group) {
                $group->group("/services", function (RouteCollectorProxy $group) {
                    $group->group("/linktree", function (RouteCollectorProxy $group) {
                        $group->map(["GET"], "", LinktreeGetAction::class);
                        $group->map(["PATCH"], "", LinktreeEditAction::class);
                        $group->map(["DELETE"], "", LinktreeDeleteAction::class);
                    });
                    $group->group("/referrals", function (RouteCollectorProxy $group) {
                        $group->map(["POST"], "",  ReferralCreateAction::class);
                        $group->group("/[{code}]", function (RouteCollectorProxy $group) {
                            $group->map(["GET"], "", ReferralGetAction::class);
                            $group->map(["PATCH"], "", ReferralEditAction::class);
                            $group->map(["DELETE"], "", ReferralDeleteAction::class);
                        });
                    });
                });
            })->add(AuthMiddleware::class);
        });

        $this->app->group("/services", function (RouteCollectorProxy $group) {
            $group->map(["GET"], "/referral/{refcode}", ReferralClickAction::class);
            $group->map(["GET"], "/linktree/{name}", LinktreeClickAction::class);
        });
    }
}
