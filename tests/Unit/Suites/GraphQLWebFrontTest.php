<?php

declare(strict_types = 1);

namespace LizardsAndPumpkins\GraphQL;

use LizardsAndPumpkins\Core\Factory\Factory;
use LizardsAndPumpkins\Http\HttpRequest;
use LizardsAndPumpkins\Http\HttpResponse;
use LizardsAndPumpkins\Http\Routing\HttpRequestHandler;
use LizardsAndPumpkins\Http\Routing\HttpRouter;
use LizardsAndPumpkins\Http\Routing\HttpRouterChain;
use LizardsAndPumpkins\Http\WebFront;
use LizardsAndPumpkins\Core\Factory\MasterFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LizardsAndPumpkins\GraphQL\GraphQLWebFront
 */
class GraphQLWebFrontTest extends TestCase
{
    private GraphQLWebFront $webFront;

    final protected function setUp(): void
    {
        $dummyHttpRequest = $this->createStub(HttpRequest::class);
        $dummyFactory = $this->createStub(Factory::class);

        $stubHttpResponse = $this->createStub(HttpResponse::class);
        $stubHttpResponse->method('getStatusCode')->willReturn(HttpResponse::STATUS_OK);

        $stubHttpRequestHandler = $this->createStub(HttpRequestHandler::class);
        $stubHttpRequestHandler->method('process')->willReturn($stubHttpResponse);

        $stubRouterChain = $this->createStub(HttpRouterChain::class);
        $stubRouterChain->method('route')->willReturn($stubHttpRequestHandler);

        $stubMasterFactory = $this->getMockBuilder(MasterFactory::class)
            ->onlyMethods(get_class_methods(MasterFactory::class))
            ->addMethods([
                'createHttpRouterChain',
                'createGraphQLRouter',
            ])
            ->getMock();
        $stubMasterFactory->method('createHttpRouterChain')->willReturn($stubRouterChain);
        $stubMasterFactory->method('createGraphQLRouter')->willReturn($this->createStub(HttpRouter::class));

        $this->webFront = new class(
            $dummyHttpRequest,
            $stubMasterFactory,
            $dummyFactory
        ) extends GraphQLWebFront {
            private MasterFactory $testMasterFactory;

            public function __construct(
                HttpRequest $request,
                MasterFactory $testMasterFactory,
                Factory $stubFactory
            ) {
                parent::__construct($request, $stubFactory);

                $this->testMasterFactory = $testMasterFactory;
            }

            final protected function createMasterFactory() : MasterFactory
            {
                return $this->testMasterFactory;
            }
        };
    }

    public function testIsWebFront(): void
    {
        $this->assertInstanceOf(WebFront::class, $this->webFront);
    }

    public function testReturnsHttpResponse(): void
    {
        $this->assertInstanceOf(HttpResponse::class, $this->webFront->processRequest());
    }
}
