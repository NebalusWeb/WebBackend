<?php

namespace Nebalus\Ownsite\Collector;

use Nebalus\Ownsite\Controller\DocsController;
use Nebalus\Ownsite\Controller\HomeController;
use Nebalus\Ownsite\Controller\LinktreeController;
use Nebalus\Ownsite\Controller\ReferralController;
use Nebalus\Ownsite\Controller\TempController;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Routing\RouteCollectorProxy;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Throwable;
use Twig\Error\LoaderError;

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

        // Definiert die ErrorMiddleware
        $displayErrorDetails = (strtolower(getenv("APP_ENV")) === "development");
        $errorMiddleware = $this->app->addErrorMiddleware($displayErrorDetails, true, true);
        $errorMiddleware->setErrorHandler(HttpNotFoundException::class, function () use ($app) {
            $response = $app->getResponseFactory()->createResponse();
            $response = $response->withAddedHeader("Location", "/");
            return $response->withStatus(307);
        });

        // Definiert die Routen
        $app->redirect("/", "/homepage", 301);
        $app->group("/api", function (RouteCollectorProxy $group) {
            $group->get("/account", [TempController::class, "action"]);
            $group->group("/projects", function (RouteCollectorProxy $group) {
                $group->group("/linktree", function (RouteCollectorProxy $group) {
                    $group->post("/create", [TempController::class, "action"]);
                    $group->get("/read", [TempController::class, "action"]);
                    $group->post("/update", [TempController::class, "action"]);
                    $group->delete("/delete", [TempController::class, "action"]);
                });
                $group->group("/referal", function (RouteCollectorProxy $group) {
                    $group->post("/create", [TempController::class, "action"]);
                    $group->get("/read", [TempController::class, "action"]);
                    $group->post("/update", [TempController::class, "action"]);
                    $group->delete("/delete", [TempController::class, "action"]);
                });
                $group->group("/game", function (RouteCollectorProxy $group) {
                    $group->group("/cosmoventure", function (RouteCollectorProxy $group) {
                        $group->get("/version", [TempController::class, "action"]);
                    });
                });
            });
        });
        $app->group("/terms", function (RouteCollectorProxy $group) {
            $group->get("/privacy", [TempController::class, "action"]);
        });
        $app->get("/docs", [DocsController::class, "docs"]);
        $app->get("/homepage", [HomeController::class, "home"]);
        $app->get("/linktree", [LinktreeController::class, "linktree"]);
        $app->get("/cosmoventure", [TempController::class, "action"]);
        $app->get("/melody", [TempController::class, "action"]);
        $app->get("/ref", [ReferralController::class, "referral"]);

        //
        $twig = Twig::create(__DIR__ . '/../../templates', [
            'cache' => __DIR__ . '/../..' . getenv("TWIG_CACHE"),
            'charset' => getenv("TWIG_CHARSET"),
            'debug' => getenv("TWIG_DEBUG")
        ]);
        $app->add(TwigMiddleware::create($app, $twig));
    }
}
