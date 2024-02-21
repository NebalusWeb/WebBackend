<?php

use TestApi\Collector\RouteCollector;
use TestApi\Factory\DiContainerFactory;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$containerFactory = new DiContainerFactory();
$container = $containerFactory->build();

$app = AppFactory::createFromContainer($container);

$routes = new RouteCollector($app);
$routes->initRoutes();

$app->run();