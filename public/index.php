<?php

declare(strict_types=1);

use function Src\Core\Utils\Helpers\getdir;

session_start();

require_once str_replace("\\", "/", __DIR__) . "/../src/core/utils/helpers/getdir.php";

require_once getdir(__DIR__) . '/../vendor/autoload.php';
Dotenv\Dotenv::createImmutable(getdir(__DIR__) . '/../')->load();


require_once getdir(__DIR__) . '/../src/core/__init.php';
