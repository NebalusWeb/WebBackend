<?php

namespace Nebalus\Ownsite\Collector;

use Nebalus\Ownsite\Controller\DocsController;
use Nebalus\Ownsite\Controller\HomeController;
use Nebalus\Ownsite\Controller\LinktreeController;
use Nebalus\Ownsite\Controller\Referral\ReferralController;
use Nebalus\Ownsite\Controller\TempController;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteCollectorProxy;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

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

        // Loads TWIG
        $twigConfig = [];
        if (getenv("TWIG_CACHE")) {
            $twigConfig["cache"] = "/var/www" . getenv("TWIG_CACHE");
        }
        if (getenv("TWIG_DEBUG")) {
            $twigConfig["debug"] = getenv("TWIG_DEBUG");
        }
        if (getenv("TWIG_CHARSET")) {
            $twigConfig["charset"] = getenv("TWIG_CHARSET");
        }

        $twig = Twig::create(__DIR__ . '/../../templates', $twigConfig);
        $app->add(TwigMiddleware::create($app, $twig));

    // Definiert die Route
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
        $app->get("/homepage", [HomeController::class, "home"]);
        $app->get("/docs", [DocsController::class, "docs"]);
        $app->get("/linktree", [LinktreeController::class, "linktree"]);
        $app->get("/ref", [ReferralController::class, "referral"]);
        $app->get("/oriri", [TempController::class, "action"]);
        $app->get("/cosmoventure", [TempController::class, "action"]);
        $app->get("/melody", [TempController::class, "action"]);
    }
}
