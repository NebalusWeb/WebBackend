<?php

namespace Nebalus\Webapi\Factory;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

class ResponseFactory implements ResponseFactoryInterface
{
    #[\Override] public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        $res = new Response($code);

        if ($reasonPhrase !== '') {
            $res = $res->withStatus($code, $reasonPhrase);
        }

        return $res->withAddedHeader("Content-Type", "application/json");
    }
}
