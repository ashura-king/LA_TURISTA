<?php

use Src\Core\App;
use Src\Core\Component;
use Src\Core\Utils\Includes\Redirect;

use function Src\Core\Utils\Helpers\getdir;

function json(mixed $data)
{
    header("Content-Type: application/json");
    echo json_encode($data);
}

function view(string $view, array $data = [])
{
    header("Content-Type: text/html");

    $view = str_replace(".", "/", $view);

    $path = getdir(__DIR__) . "/../../../views/{$view}.blade.php";

    if (file_exists($path)) {
        extract($data);
        require $path;
        return;
    }

    $path = str_replace("{$view}.blade.php", "{$view}.php", $path);

    if (file_exists($path)) {
        extract($data);
        require $path;
        return;
    }

    echo "<script>alert('Error: Could not find specified view.');</script>";
}

function redirect($location = null)
{
    if ($location) {
        header("Location: $location");
        exit();
    } else {
        include_once('redirect.php');
        return new Redirect();
    }
}

function component(string $component, array $data = [])
{
    header("Content-Type: text/html");

    $component = str_replace(".", "/", $component);

    $path = getdir(__DIR__) . "/../../../views/components/{$component}.blade.php";

    if (file_exists($path)) {
        extract($data);
        require $path;
        return;
    }

    echo "<script>alert('Error: Could not find specified component.');</script>";
}