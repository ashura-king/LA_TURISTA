<?php


namespace Src\Core;

class App
{
    public string $URI_PATH;

    public function __construct(string $path = '')
    {
        if (!empty($path)) {
            $this->URI_PATH = $path;
        } elseif (
            $_SERVER["SERVER_NAME"] === "localhost" &&
            $_SERVER["SERVER_PORT"] >= 3000
        ) {
            $this->URI_PATH = $_SERVER['PATH_INFO'] ?? $_SERVER['PHP_SELF'];
        } else {
            $this->URI_PATH = isset($_GET["url"]) ? "/" . $_GET["url"] : "/Home";
        }

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit();
        }
    }

    static function debugPrint(mixed $prop)
    {
        echo "<pre>";
        (is_array($prop) ? print_r($prop) : var_dump($prop));
        echo "</pre>";
    }
}
