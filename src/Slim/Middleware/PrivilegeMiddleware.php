<?php

namespace Nebalus\Webapi\Slim\Middleware;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNode;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNodeCollection;
use Override;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

readonly class PrivilegeMiddleware implements MiddlewareInterface
{
    /**
     * @throws ApiException
     */
    #[Override] public function process(Request $request, RequestHandler $handler): Response
    {
        $test = PrivilegeNodeCollection::fromObjects(
            PrivilegeNode::fromString("feature", true),
            PrivilegeNode::fromString("admin", true),
        );

//        $testZwei = PrivilegeNode::fromString("feature.referral.create", false, 1);

//        var_dump($testZwei->getNode()->asDestructured());
//        var_dump($test->contains(PurePrivilegeNode::fromString("admin.test.testii.testiii.fdyfyf.aysfysayf")));

        $request = $request->withAttribute("userPrivileges", $test);

        return $handler->handle($request);
    }
}
