<?php

use Nebalus\Ownsite\Collector\RouteCollector;
use Nebalus\Ownsite\Factory\DiContainerFactory;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$containerFactory = new DiContainerFactory();
$container = $containerFactory->build();

$app = AppFactory::createFromContainer($container);

$routes = new RouteCollector($app);
$routes->init();

$app->run();
