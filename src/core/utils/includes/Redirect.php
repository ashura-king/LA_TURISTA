<?php

namespace Src\Core\Utils\Includes;

use Src\Core\App;
use Src\Core\Router;
use Src\Core\Utils\Request;

class Redirect
{
    public function internal(string $path, Request $request, string $method)
    {
        new Router(new App($path), $request, $method);
    }
}
