<?php

namespace Src\Core\Utils\Mono_Cli;

use function Src\Core\Utils\Helpers\getdir;

require_once str_replace("\\", "/", __DIR__) . "/../helpers/getdir.php";
require_once getdir(__DIR__) . '/../../../../vendor/autoload.php';

require_once getdir(__DIR__) . '/../../Controller.php';
require_once getdir(__DIR__) . '/Generate.php';

if (isset($argv[1]) && (isset($argv[2]) || isset($argv[3]))) {

    $mode = $argv[1] ?? "";
    $type = $argv[2] ?? "";
    $filename = $argv[3] ?? "";

    if ($mode === "gen") {
        if ($type === 'con' or $type === 'controller') {
            Generate::createNewController($filename);
        } elseif ($type === 'mod' or $type === 'model') {
            Generate::createNewModel($filename);
        } elseif ($type === 'vw' or $type === 'view') {
            Generate::createView($filename);
        } elseif ($type === 'comp' or $type === 'component') {
            Generate::createNewComponent($filename);
        } elseif ($type === 'mid' or $type === 'middleware') {
            Generate::createMiddleware($filename);
        } elseif ($type === 'ser' or $type === 'service') {
            Generate::createControllerService($filename);
        }
    } elseif ($mode === "fill") {
        Generate::fillSchema($argv[2]);
    }
}

echo "invalid mono command\n";
