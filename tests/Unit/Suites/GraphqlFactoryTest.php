<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\RestApi;

use LizardsAndPumpkins\Core\Factory\Factory;
use LizardsAndPumpkins\Core\Factory\MasterFactory;
use LizardsAndPumpkins\GraphQL\GraphQLFactory;
use LizardsAndPumpkins\GraphQL\GraphQLRouter;
use LizardsAndPumpkins\GraphQL\SchemaRegistry;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LizardsAndPumpkins\GraphQL\GraphQLFactory
 * @uses   \LizardsAndPumpkins\GraphQL\GraphQLRequestHandler
 * @uses   \LizardsAndPumpkins\GraphQL\GraphQLRouter
 */
class GraphqlFactoryTest extends TestCase
{
    private GraphQLFactory $factory;

    final protected function setUp(): void
    {
        $stubMasterFactory = $this->createStub(MasterFactory::class);

        $this->factory = new GraphQLFactory;
        $this->factory->setMasterFactory($stubMasterFactory);
    }

    public function testIsFactory(): void
    {
        $this->assertInstanceOf(Factory::class, $this->factory);
    }

    public function testGraphQLRouterIsReturned(): void
    {
        $this->assertInstanceOf(GraphQLRouter::class, $this->factory->createGraphQLRouter());
    }

    public function testReturnsSchemaRegistry(): void
    {
        $this->assertInstanceOf(SchemaRegistry::class, $this->factory->getSchemaRegistry());
    }

    public function testReturnsSameInstanceOfSchemaRegistry(): void
    {
        $this->assertSame($this->factory->getSchemaRegistry(), $this->factory->getSchemaRegistry());
    }
}
