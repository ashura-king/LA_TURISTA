<?php

namespace Src\Core;

use Src\Core\Utils\Request;

abstract class Middleware
{
    abstract static function runnable(Request $request, callable $next);
}