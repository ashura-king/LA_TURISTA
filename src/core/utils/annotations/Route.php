<?php

namespace Src\Core\Utils\Annotations;

use Attribute;

#[Attribute()]
class Route
{
    public array $path;
    public string $method;

    public function __construct(string $path = "", string $method = "GET")
    {
        $this->path = explode("/", $path);
        $this->method = strtoupper($method);
    }
}
