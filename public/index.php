<?php

use Nebalus\Webapi\Factory\DiContainerFactory;
use Nebalus\Webapi\Slim\RouteCollector;
use Slim\App;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$diContainerFactory = new DiContainerFactory();
$diContainer = $diContainerFactory->build();

$slimApp = AppFactory::createFromContainer($diContainer);
$diContainer->set(App::class, $slimApp);

$routes = $diContainer->get(RouteCollector::class);
$routes->init();

$slimApp->run();
