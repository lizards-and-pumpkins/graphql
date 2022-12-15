<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\GraphQL;

use GraphQL\GraphQL;
use LizardsAndPumpkins\Http\GenericHttpResponse;
use LizardsAndPumpkins\Http\HttpRequest;
use LizardsAndPumpkins\Http\HttpResponse;
use LizardsAndPumpkins\Http\Routing\HttpRequestHandler;

class GraphQLRequestHandler implements HttpRequestHandler
{
    private SchemaRegistry $schemaRegistry;

    public function __construct(SchemaRegistry $schemaRegistry)
    {
        $this->schemaRegistry = $schemaRegistry;
    }

    public function canProcess(HttpRequest $request): bool
    {
        return true;
    }

    public function process(HttpRequest $request): HttpResponse
    {
        $input = json_decode($request->getRawBody(), true);

        try {
            $body = json_encode(GraphQL::executeQuery(
                $this->schemaRegistry->get(),
                $input['query'] ?? '',
                null,
                null,
                $input['variables'] ?? null
            )->toArray());

            return GenericHttpResponse::create($body, $this->getHeaders(), HttpResponse::STATUS_OK);
        } catch (\Throwable $exception) {
            return GenericHttpResponse::create(
                json_encode(['errors' => [['message' => $exception->getMessage()]]]),
                $this->getHeaders(),
                HttpResponse::STATUS_BAD_REQUEST
            );
        }
    }

    private function getHeaders(): array
    {
        return [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => '*',
            'Access-Control-Allow-Headers' => 'Content-Type',
            'Content-Type' => 'application/json',
        ];
    }
}
