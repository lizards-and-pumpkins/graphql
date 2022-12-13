<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\GraphQL;

use LizardsAndPumpkins\Http\HttpRequest;
use LizardsAndPumpkins\Http\Routing\HttpRequestHandler;
use LizardsAndPumpkins\Http\Routing\HttpRouter;

class GraphQLRouter implements HttpRouter
{
    private GraphQLRequestHandler $requestHandler;

    public function __construct(GraphQLRequestHandler $requestHandler)
    {
        $this->requestHandler = $requestHandler;
    }

    public function route(HttpRequest $request): ?HttpRequestHandler
    {
        return $this->requestHandler;
    }
}
