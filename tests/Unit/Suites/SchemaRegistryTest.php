<?php

declare(strict_types=1);

namespace Uhrenschmuck24\GraphQL;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use LizardsAndPumpkins\GraphQL\SchemaRegistry;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LizardsAndPumpkins\GraphQL\SchemaRegistry
 */
class SchemaRegistryTest extends TestCase
{
    public function testReturnsSchema(): void
    {
        $this->assertInstanceOf(Schema::class, (new SchemaRegistry)->get());
    }

    public function testAddsTypesToSchema(): void
    {
        $registry = new SchemaRegistry;
        $registry->add('Query', ['foo' => [
            'type' => Type::string(),
        ]]);

        $this->assertContains('foo', $registry->get()->getConfig()->getQuery()->getFieldNames());
    }
}
