<?php

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Core\Utils\Annotations\Get;
use Src\Core\Utils\Request;
use Src\Core\Utils\Annotations\Middleware;
use Src\Middlewares\Authentication;
use Src\Services\AuthService;

class Webfront extends Controller
{

	#[Get()]
	#[Middleware(new Authentication)]
	public function index(Request $request)
	{
		$authUser = AuthService::getAuthenticatedUser();

		if (!$authUser) {
			return view("webfront");
		}

		return view("webfront", [
			"user" => $authUser
		]);
	}
}
