<?php

namespace Src\Middlewares;

use Src\Core\App;
use Src\Core\Middleware;
use Src\Core\Utils\Request;
use Src\Core\Utils\Token;

class Authentication extends Middleware
{
	static function runnable(Request $request, callable $next)
	{
		$token = $_COOKIE['auth_token'] ?? null;
		$route = $request->uri;

		if ($token == null) {
			if (!str_contains($route, 'auth')) {
				return redirect('/auth/login');
			} else {
				return $next();
			}
		}

		if ($token && $route === '/auth/logout') {
			return $next();
		}

		if ($token && str_contains($route, 'auth')) {
			return redirect('/webfront');
		}

		$payload = Token::verify($token, $_ENV['SECRET_KEY']);

		if (!$payload) {
			return redirect('/front');
		}

		return $next();
	}
}
