<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Slim;

use Nebalus\Webapi\Api\Action\Referral\ReferralClickAction;
use Nebalus\Webapi\Api\Action\User\UserAuthAction;
use Nebalus\Webapi\Api\Action\Temp\TempAction;
use Nebalus\Webapi\Api\Service\Referral\ReferralClickService;
use Nebalus\Webapi\Api\View\User\UserAuthView;
use Nebalus\Webapi\Option\EnvData;
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
        });

        $this->app->group("/services", function (RouteCollectorProxy $group) {
            $group->map(["GET"], "/referral", ReferralClickAction::class);
        });
    }
}
