<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\GraphQL;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;

class SchemaRegistry
{
    private array $registry = [];

    public function add(string $type, array $directive): void
    {
        if (! isset($this->registry[$type])) {
            $this->registry[$type] = ['fields' => []];
        }

        $this->registry[$type]['fields'] = array_merge($this->registry[$type]['fields'], $directive);
    }

    public function get(): Schema
    {
        return new Schema(array_reduce(array_keys($this->registry), function (array $carry, string $type) {
            return array_merge($carry, [strtolower($type) => new ObjectType([
                'name' => ucfirst($type),
                'fields' => $this->registry[$type]['fields'],
            ])]);
        }, []));
    }
}
