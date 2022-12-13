<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\GraphQL;

use LizardsAndPumpkins\Core\Factory\Factory;
use LizardsAndPumpkins\Core\Factory\FactoryTrait;

class GraphQLFactory implements Factory
{
    use FactoryTrait;

    private SchemaRegistry $schemaRegistry;

    public function createGraphQLRouter(): GraphQLRouter
    {
        return new GraphQLRouter($this->createGraphQLRequestHandler());
    }

    public function getSchemaRegistry(): SchemaRegistry
    {
        if (! isset($this->schemaRegistry)) {
            $this->schemaRegistry = new SchemaRegistry;
        }

        return $this->schemaRegistry;
    }

    private function createGraphQLRequestHandler(): GraphQLRequestHandler
    {
        return new GraphQLRequestHandler($this->getSchemaRegistry());
    }
}
