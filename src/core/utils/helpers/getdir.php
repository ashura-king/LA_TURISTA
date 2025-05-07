<?php

namespace Src\Core\Utils\Helpers;

function getdir(string $dir): string
{
    return str_replace("\\", "/", $dir);
}
