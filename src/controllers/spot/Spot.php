<?php

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Core\Utils\Annotations\Get;
use Src\Core\Utils\Request;
use Src\Services\AuthService;

class Spot extends Controller
{
	#[Get()]
	public function index(Request $request)
	{

		$authUser = AuthService::getAuthenticatedUser();

		if (!$authUser) {
			return view("spot");
		}

		return view("spot", [
			"user" => $authUser
		]);
	}
}
