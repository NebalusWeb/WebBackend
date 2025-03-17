<?php

namespace Nebalus\Webapi\Slim\Middleware;

use Override;
use Prometheus\CollectorRegistry;
use Prometheus\Exception\MetricsRegistrationException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

readonly class MetricsMiddleware implements MiddlewareInterface
{
    public function __construct(
        private CollectorRegistry $metricRegistry,
    ) {
    }

    #[Override] public function process(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        try {
            $this->metricRegistry->getOrRegisterCounter("backend", "api_endpoint", "Total number of requests", ["scheme", "methode", "path", "code"])->inc([$request->getUri()->getScheme(), $request->getMethod(), $request->getUri()->getPath(), $response->getStatusCode()]);
        } catch (MetricsRegistrationException) {
        }

        return $response;
    }
}
