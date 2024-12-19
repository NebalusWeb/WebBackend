<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Slim;

use Nebalus\Webapi\Api\Linktree\Action\Analytics\LinktreeClickAction;
use Nebalus\Webapi\Api\Linktree\Action\Analytics\LinktreeClickHistoryAction;
use Nebalus\Webapi\Api\Linktree\Action\LinktreeDeleteAction;
use Nebalus\Webapi\Api\Linktree\Action\LinktreeEditAction;
use Nebalus\Webapi\Api\Linktree\Action\LinktreeGetAction;
use Nebalus\Webapi\Api\Metrics\MetricsAction;
use Nebalus\Webapi\Api\Referral\Action\Analytics\ReferralClickAction;
use Nebalus\Webapi\Api\Referral\Action\Analytics\ReferralClickHistoryAction;
use Nebalus\Webapi\Api\Referral\Action\ReferralCreateAction;
use Nebalus\Webapi\Api\Referral\Action\ReferralDeleteAction;
use Nebalus\Webapi\Api\Referral\Action\ReferralEditAction;
use Nebalus\Webapi\Api\Referral\Action\ReferralGetAction;
use Nebalus\Webapi\Api\User\Action\UserAuthAction;
use Nebalus\Webapi\Api\User\Action\UserRegisterAction;
use Nebalus\Webapi\Option\EnvData;
use Nebalus\Webapi\Slim\Middleware\AuthenticationMiddleware;
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
            $group->map(["POST"], "/register", UserRegisterAction::class);
            $group->group("/admin", function (RouteCollectorProxy $group) {
                $group->group("/user/{username}", function (RouteCollectorProxy $group) {
                });
            })->add(AuthenticationMiddleware::class);
            $group->group("/user/{username}", function (RouteCollectorProxy $group) {
                //$group->map(["GET"], "/permissions", PermissionsGetAction::class);
                $group->group("/services", function (RouteCollectorProxy $group) {
                    $group->group("/invitationtoken", function (RouteCollectorProxy $group) {
                    });
                    $group->group("/linktree", function (RouteCollectorProxy $group) {
                        $group->map(["GET"], "", LinktreeGetAction::class);
                        $group->map(["PATCH"], "", LinktreeEditAction::class);
                        $group->map(["DELETE"], "", LinktreeDeleteAction::class);
                        $group->map(["GET"], "/click_history", LinktreeClickHistoryAction::class);
                    });
                    $group->group("/referrals", function (RouteCollectorProxy $group) {
                        $group->map(["POST"], "", ReferralCreateAction::class);
                        $group->group("/{code}", function (RouteCollectorProxy $group) {
                            $group->map(["GET"], "", ReferralGetAction::class);
                            $group->map(["PATCH"], "", ReferralEditAction::class);
                            $group->map(["DELETE"], "", ReferralDeleteAction::class);
                            $group->map(["GET"], "/click_history", ReferralClickHistoryAction::class);
                        });
                    });
                });
            })->add(AuthenticationMiddleware::class);
        });

        $this->app->map(["GET"], "/metrics", MetricsAction::class);

        $this->app->group("/services", function (RouteCollectorProxy $group) {
            $group->map(["GET"], "/referral", ReferralClickAction::class);
            $group->map(["GET"], "/linktree", LinktreeClickAction::class);
        });
    }
}
