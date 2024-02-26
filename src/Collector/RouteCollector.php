<?php

namespace Nebalus\Ownsite\Collector;

use Nebalus\Ownsite\Controller\DocsController;
use Nebalus\Ownsite\Controller\HomeController;
use Nebalus\Ownsite\Controller\Referral\Api\ReferralApiCreateController;
use Nebalus\Ownsite\Controller\Referral\Api\ReferralApiDeleteController;
use Nebalus\Ownsite\Controller\Referral\Api\ReferralApiReadController;
use Nebalus\Ownsite\Controller\Referral\Api\ReferralApiUpdateController;
use Nebalus\Ownsite\Controller\Referral\ReferralController;
use Nebalus\Ownsite\Controller\Linktree\Api\LinktreeApiCreateController;
use Nebalus\Ownsite\Controller\Linktree\Api\LinktreeApiDeleteController;
use Nebalus\Ownsite\Controller\Linktree\Api\LinktreeApiReadController;
use Nebalus\Ownsite\Controller\Linktree\Api\LinktreeApiUpdateController;
use Nebalus\Ownsite\Controller\Linktree\LinktreeController;
use Nebalus\Ownsite\Controller\TempController;
use Nebalus\Ownsite\Middleware\JsonValidatorMiddleware;
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
                    $group->post("/create", [LinktreeApiCreateController::class, "action"]);
                    $group->get("/read", [LinktreeApiReadController::class, "action"]);
                    $group->post("/update", [LinktreeApiUpdateController::class, "action"]);
                    $group->delete("/delete", [LinktreeApiDeleteController::class, "action"]);
                });
                $group->group("/referral", function (RouteCollectorProxy $group) {
                    $group->post("/create", [ReferralApiCreateController::class, "action"]);
                    $group->get("/read", [ReferralApiReadController::class, "action"]);
                    $group->post("/update", [ReferralApiUpdateController::class, "action"]);
                    $group->delete("/delete", [ReferralApiDeleteController::class, "action"]);
                });
                $group->group("/games", function (RouteCollectorProxy $group) {
                    $group->group("/cosmoventure", function (RouteCollectorProxy $group) {
                        $group->get("/version", [TempController::class, "action"]);
                    });
                });
            });
        })->add(new JsonValidatorMiddleware());

        $app->group("/account", function (RouteCollectorProxy $group) {
            $group->get("/register", [TempController::class, "action"]);
            $group->get("/login", [TempController::class, "action"]);
            $group->get("/dashboard", [TempController::class, "action"]);
        });

        $app->group("/terms", function (RouteCollectorProxy $group) {
            $group->get("/privacy", [TempController::class, "action"]);
        });

        $app->group("/projects", function (RouteCollectorProxy $group) {
            $group->get("/mandelbrot", [TempController::class, "action"]);
            $group->get("/oriri", [TempController::class, "action"]);
            $group->get("/cosmoventure", [TempController::class, "action"]);
            $group->get("/melody", [TempController::class, "action"]);
        });
        
        $app->get("/homepage", [HomeController::class, "action"]);
        $app->get("/docs", [DocsController::class, "action"]);
        $app->get("/linktree", [LinktreeController::class, "action"]);
        $app->get("/ref", [ReferralController::class, "action"]);
    }
}
