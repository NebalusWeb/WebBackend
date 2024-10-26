<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Action\Temp;

use Nebalus\Webapi\Action\ApiAction;
use Nebalus\Webapi\Value\Result\Result;
use Slim\Http\ServerRequest as Request;
use Slim\Http\Response as Response;

class TempAction extends ApiAction
{
    protected function execute(Request $request, Response $response, array $args): Response
    {
        $bodyParams = $request->getParsedBody() ?? [];
        $result = Result::createSuccess(null, 200, ["HAsLL" => "dssd", "sdfsf" => "d3432d", "HALsdsdL" => "ds2432542354sd"]);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
