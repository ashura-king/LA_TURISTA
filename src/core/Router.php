<?php

namespace Src\Core;

use ReflectionClass;
use Src\Controllers\_404;
use Src\Core\Utils\Annotations\Route;
use Src\Core\Utils\Request;

use function Src\Core\Utils\Helpers\getdir;

class Router
{
    private App $app;
    private array $URL;
    private Controller $controller;
    private Controller $errorController;
    private Request $request;
    private string $requestMethod;

    public function __construct(App $app, Request $request = new Request(), $method = null)
    {
        $this->app = $app;
        $this->URL = explode("/", $this->app->URI_PATH);

        $this->request = $request;
        $this->requestMethod = $method ?? $_SERVER['REQUEST_METHOD'];

        require_once $this->formatPath("_404");
        $this->errorController = new _404();
        $this->findController();
    }

    private function findController(): void
    {
        $route = $this->dashToCamel(ucfirst($this->URL[1]));

        $route = $route === 'Index.php' ? 'Home' : $route;
        $controller = $this->formatPath($route);

        if (file_exists($controller)) {
            $this->requireController($controller, $route);
            return;
        }

        $controller = $this->formatPath($route, true);

        if (file_exists($controller)) {
            $this->requireController($controller, $route);
            return;
        }

        Controller::HandleError($this->errorController, $this->request);
    }

    private function requireController(string $controller, string $route)
    {
        require_once $controller;

        $controllerClass = $route;
        eval("\$this->controller = new Src\Controllers\\$controllerClass();");

        array_shift($this->URL);

        include_once getdir(__DIR__) . '/utils/includes/response_methods.php';

        $reflection = new ReflectionClass($this->controller);

        $valid = Controller::handleMiddlewares(
            $reflection,
            new Request()
        );

        if ($valid) {
            $this->handleMatchRoute($reflection);
        }
    }

    protected function handleMatchRoute(ReflectionClass $reflection): void
    {
        $route = $this->URL;
        $route[0] = "";

        foreach ($reflection->getMethods() as $method) {
            $attributes = $method->getAttributes();

            foreach ($attributes as $attribute) {
                $attr = $attribute->newInstance();

                if ($attr instanceof Route && $this->requestMethod === $attr->method) {

                    if (sizeof($attr->path) === sizeof($route)) {
                        $params = [];

                        for ($i = 0; $i < sizeof($attr->path); $i++) {
                            if (str_contains($attr->path[$i], ":")) {
                                $key = str_replace(":", "", $attr->path[$i]);
                                $params[$key] = $route[$i];
                                $attr->path[$i] = $route[$i];
                            }
                        }

                        if ($attr->path === $route) {
                            $this->request->param = $params;
                            Controller::getMethod($this->controller, $method, $this->request);

                            return;
                        }
                    }
                }
            }
        }

        Controller::HandleError($this->errorController, $this->request);
    }

    private function formatPath(string $className, bool $withFolder = false): string
    {
        $folder = $this->camelToDash($className);

        return getdir(__DIR__) . "/../controllers/" . ($withFolder ? "$folder/$className" : $className) . ".php";
    }

    private function dashToCamel($string)
    {
        $words = explode('-', $string);
        $route = "";

        for ($i = 0; $i < sizeof($words); $i++) {
            $route .= ucfirst($words[$i]);
        }

        return $route;
    }

    private function camelToDash($string)
    {
        $words = preg_split("/(?=[A-Z])/", $string);

        $route = "";

        for ($i = 1; $i < sizeof($words); $i++) {
            $route .= $words[$i] . (array_key_last($words) !== $i ? "-" : "");
        }

        return strtolower($route);
    }
}