<?php

namespace Src\Controllers;

use Src\Core\App;
use Src\Core\Controller;
use Src\Core\Utils\Annotations\Get;
use Src\Core\Utils\Request;
use Src\Services\AuthService;

class Place extends Controller
{
	#[Get()]
	public function index(Request $request)
	{
		$authUser = AuthService::getAuthenticatedUser();

		if (!$authUser) {
			return view("place");
		}

		return view("place", [
			"user" => $authUser
		]);
	}
}
