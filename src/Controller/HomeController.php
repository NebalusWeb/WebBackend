<?php

namespace Nebalus\Ownsite\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class HomeController
{

    private Twig $twig;

    public function __construct(Twig $twig) {
        $this->twig = $twig;
    }

    public function action(Request $request, Response $response, array $args): Response
    {
        return $this->twig->render($response, "homepage.twig")->withStatus(200);
    }

}