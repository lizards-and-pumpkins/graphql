<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\GraphQL;

use LizardsAndPumpkins\Core\Factory\MasterFactory;
use LizardsAndPumpkins\Http\GenericHttpResponse;
use LizardsAndPumpkins\Http\HttpFactory;
use LizardsAndPumpkins\Http\HttpResponse;
use LizardsAndPumpkins\Http\Routing\HttpRouterChain;
use LizardsAndPumpkins\Http\WebFront;

abstract class GraphQLWebFront extends WebFront
{
    protected function registerFactories(MasterFactory $factory): void
    {
        $factory->register(new HttpFactory);
        $factory->register(new GraphQLFactory);
        $factory->register($this->getImplementationSpecificFactory());
    }

    final protected function registerRouters(HttpRouterChain $routerChain): void
    {
        $routerChain->register($this->getMasterFactory()->createGraphQLRouter());
    }
}
