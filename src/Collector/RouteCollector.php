<?php

namespace Nebalus\Ownsite\Collector;

use Nebalus\Ownsite\Controller\TestController;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Routing\RouteCollectorProxy;
use Throwable;

class RouteCollector
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function initRoutes(): void
    {
        global $app;

        $app->redirect("/", "/homepage", 301);
        $app->group("/api", function (RouteCollectorProxy $group) {
            $group->get("/account", [TestController::class, "action"]);
            $group->group("/projects", function (RouteCollectorProxy $group) {
                $group->group("/linktree", function (RouteCollectorProxy $group) {
                    $group->post("/create", [TestController::class, "action"]);
                    $group->get("/read", [TestController::class, "action"]);
                    $group->post("/update", [TestController::class, "action"]);
                    $group->delete("/delete", [TestController::class, "action"]);
                });
                $group->group("/referal", function (RouteCollectorProxy $group) {
                    $group->post("/create", [TestController::class, "action"]);
                    $group->get("/read", [TestController::class, "action"]);
                    $group->post("/update", [TestController::class, "action"]);
                    $group->delete("/delete", [TestController::class, "action"]);
                });
                $group->group("/game", function (RouteCollectorProxy $group) {
                    $group->group("/cosmoventure", function (RouteCollectorProxy $group) {
                        $group->get("/version", [TestController::class, "action"]);
                    });
                });
            });
        });
        $app->group("/terms", function (RouteCollectorProxy $group) {
            $group->get("/privacy", [TestController::class, "action"]);
        });
        $app->get("/docs", [TestController::class, "action"]);
        $app->get("/homepage", [TestController::class, "action"]);
        $app->get("/linktree", [TestController::class, "action"]);
        $app->get("/cosmoventure", [TestController::class, "action"]);
        $app->get("/melody", [TestController::class, "action"]);
        $app->get("/ref", [TestController::class, "action"]);

        $errorMiddleware = $this->app->addErrorMiddleware(true, true, true);
        $errorMiddleware->setErrorHandler(HttpNotFoundException::class, function () use ($app) {
            $response = $app->getResponseFactory()->createResponse();
            $response = $response->withAddedHeader("Location", "/");
            return $response->withStatus(307);
        });
    }
}
