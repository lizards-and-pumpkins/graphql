<?php

declare(strict_types=1);

namespace Uhrenschmuck24\GraphQL;

use LizardsAndPumpkins\GraphQL\GraphQLRequestHandler;
use LizardsAndPumpkins\GraphQL\SchemaRegistry;
use LizardsAndPumpkins\Http\HttpRequest;
use LizardsAndPumpkins\Http\HttpResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LizardsAndPumpkins\GraphQL\GraphQLRequestHandler
 */
class GraphQLRequestHandlerTest extends TestCase
{
    private GraphQLRequestHandler $requestHandler;
    private SchemaRegistry $stubSchemaRegistry;

    final protected function setUp(): void
    {
        $this->stubSchemaRegistry = $this->createStub(SchemaRegistry::class);
        $this->requestHandler = new GraphQLRequestHandler($this->stubSchemaRegistry);
    }

    public function testCanAlwaysProcessRequest(): void
    {
        $dummyRequest = $this->createStub(HttpRequest::class);
        $this->assertTrue($this->requestHandler->canProcess($dummyRequest));
    }

    public function testReturnsResponseWithError(): void
    {
        $dummyRequest = $this->createStub(HttpRequest::class);
        $this->stubSchemaRegistry->method('get')->willThrowException(new \Exception);

        $result = $this->requestHandler->process($dummyRequest);

        $this->assertEquals(HttpResponse::STATUS_BAD_REQUEST, $result->getStatusCode());
    }

    public function testReturnsResponse(): void
    {
        $dummyRequest = $this->createStub(HttpRequest::class);

        $result = $this->requestHandler->process($dummyRequest);

        $this->assertEquals(HttpResponse::STATUS_OK, $result->getStatusCode());
    }
}
