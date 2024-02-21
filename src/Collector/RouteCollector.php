<?php

namespace TestApi\Collector;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

class RouteCollector
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function initRoutes(): void
    {
        $this->app->group("/projects", function (RouteCollectorProxy $group) {
            $group->get("/mandelbrot");
        });
    }
}