<?php

namespace Src\Core\Utils\Annotations;

use Attribute;
use Src\Core\Middleware as CoreMiddleware;

#[Attribute()]
class Middleware
{
    public array $middlewares;

    public function __construct(CoreMiddleware ...$middlewares)
    {
        $this->middlewares = $middlewares;
    }
}
