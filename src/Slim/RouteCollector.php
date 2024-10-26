<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Slim;

use Nebalus\Webapi\Action\Temp\TempAction;
use Nebalus\Webapi\Option\EnvData;
use Nebalus\Webapi\Slim\Middleware\CorsMiddleware;
use Slim\App;

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
        $this->app->get("/", TempAction::class);
    }
}
