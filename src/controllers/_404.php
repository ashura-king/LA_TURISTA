<?php

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Core\Utils\Annotations\Get;
use Src\Core\Utils\Request;

class _404 extends Controller {

	public static function error() {

		http_response_code(404);

		return view('404');
	}
}
