<?php

namespace Src\Core;

use function Src\Core\Utils\Helpers\getdir;

$config = require_once getdir(__DIR__) . '/../config/cors.config.php';

header("Access-Control-Allow-Origin: " . $config['origin']);
header("Access-Control-Allow-Methods: " . implode(', ', $config['allowed_methods']));
header("Access-Control-Allow-Headers: " . implode(', ', $config['allowed_headers']));

$app = new App();
$database = new Database();
$router = new Router($app);
