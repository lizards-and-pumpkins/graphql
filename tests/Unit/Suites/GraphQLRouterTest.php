<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\GraphQL;

use LizardsAndPumpkins\Http\Exception\HeaderNotPresentException;
use LizardsAndPumpkins\Http\HttpRequest;
use LizardsAndPumpkins\Http\HttpUrl;
use LizardsAndPumpkins\Http\Routing\HttpRequestHandler;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LizardsAndPumpkins\GraphQL\GraphQLRouter
 */
class GraphQLRouterTest extends TestCase
{
    public function testReturnsGraphQLRequestHandler(): void
    {
        $dummyRequest = $this->createStub(HttpRequest::class);
        $dummyGraphQlRequestHandler = $this->createStub(GraphQLRequestHandler::class);

        $result = (new GraphQLRouter($dummyGraphQlRequestHandler))->route($dummyRequest);

        $this->assertInstanceOf(GraphQLRequestHandler::class, $result);
    }
}
