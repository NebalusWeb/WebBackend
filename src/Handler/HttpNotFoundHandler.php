<?php

namespace Nebalus\Ownsite\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\ErrorHandlerInterface;
use Slim\Psr7\Response;
use Slim\Views\Twig;
use Throwable;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HttpNotFoundHandler implements ErrorHandlerInterface
{
    private Response $response;
    private Twig $twig;

    public function __construct(Response $response, Twig $twig)
    {
        $this->response = $response;
        $this->twig = $twig;
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function __invoke(
        Request $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface {
        return $this->twig->render($this->response, 'codes/404.twig')->withStatus(404);
    }
}
