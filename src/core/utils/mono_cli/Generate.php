<?php

namespace Src\Core\Utils\Mono_Cli;

use DirectoryIterator;

use function Src\Core\Utils\Helpers\getdir;

class Generate
{
    static function createNewController(string $filename, bool $end = true)
    {
        $class = ucfirst($filename);
        $folder = self::camelToDashed($class);
        $directory = getdir(__DIR__) . "/../../../controllers/$folder";

        if (!is_dir($directory)) {
            mkdir($directory);
            file_put_contents(
                $directory . "/../_404.php",
                "<?php\n\nnamespace Src\Controllers;\n\nuse Src\Core\Controller;\nuse Src\Core\Utils\Annotations\Get;\nuse Src\Core\Utils\Request;\n\nclass _404 extends Controller {\n\n\tpublic static function error() {\n\n\t\thttp_response_code(404);\n\n\t\treturn view('404');\n\t}\n}\n"
            );
        }

        file_put_contents(
            $directory . "/$class.php",
            "<?php\n\nnamespace Src\Controllers;\n\nuse Src\Core\Controller;\nuse Src\Core\Utils\Annotations\Get;\nuse Src\Core\Utils\Request;\n\nclass $class extends Controller \n{\n\t#[Get()]\n\tpublic function index(Request \$request){\n\t\treturn '$class controller';\n\t}\n}\n"
        );

        $end ?  exit() : null;
    }

    static function createControllerService(string $filename)
    {
        $class = ucfirst($filename);
        $directory = getdir(__DIR__) . "/../../../controllers";
        $folder = "$directory/" .  self::camelToDashed($class);
        $content = "<?php\n\nclass {$class}Service {";

        if (!is_dir($folder)) {
            mkdir($folder);
        }

        $controller = "$directory/$class.php";

        if (file_exists($controller)) {
            rename($controller, "$folder/$class.php");
        }

        $controller = "$folder/$class.php";

        if (!file_exists($controller)) {
            self::createNewController($filename, false);
        }

        require_once $controller;

        $methods = get_class_methods($class);

        $isInherited = fn($method) => method_exists(
            get_parent_class($class),
            $method
        );

        foreach ($methods as $method) {
            if (!$isInherited($method)) {
                $content .= "\n\tstatic function $method(Request \$request) { }\n";
            }
        }

        file_put_contents(
            $folder . "/{$class}Service.php",
            "$content \n}"
        );

        exit();
    }

    static function createNewModel(string $filename)
    {
        $class = ucfirst($filename);
        $directory = getdir(__DIR__) . "/../../../models";

        if (!is_dir($directory)) {
            mkdir($directory);
        }

        file_put_contents(
            $directory . "/$class.php",
            "<?php\n\nnamespace Src\Models;\n\nuse Src\Core\Model;\n\nclass $class extends Model {\n\tprivate \$id;\n\tpublic function __construct(\$id = null) {\n\t\t\$this->id = \$id;\n\t}\n}"
        );

        exit();
    }

    static function createNewComponent(string $filename)
    {
        $comp = $filename;
        $directory = getdir(__DIR__) . "/../../../views/components";

        $folders = explode('/', $filename);

        if (sizeof($folders) > 1) {
            foreach ($folders as $index => $path) {
                if ($index < sizeof($folders) - 1) {
                    $directory .= "/{$path}";
                } else {
                    $comp = ucfirst($path);
                }
            }
        }

        if (!is_dir($directory)) {
            mkdir($directory);
        }

        file_put_contents(
            $directory . "/$comp.blade.php",
            "<div>\n\t<h1>$comp component</h1>\n</div>"
        );

        exit();
    }

    static function createView(string $filename)
    {
        $view = $filename;
        $directory = getdir(__DIR__) . "/../../../views";

        $folders = explode('/', $filename);

        if (sizeof($folders) > 1) {
            foreach ($folders as $index => $path) {
                if ($index < sizeof($folders) - 1) {
                    $directory .= "/{$path}";
                } else {
                    $view = ucfirst($path);
                }
            }
        }

        if (!is_dir($directory)) {
            mkdir($directory);
            if ($directory === getdir(__DIR__) . "/../../../views") {
                file_put_contents(
                    $directory . "/404.blade.php",
                    "<!DOCTYPE html>\n<html lang=\"en\">\n\n<head>\n\t<meta charset=\"UTF-8\">\n\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n\t<title>Page Not Found</title>\n\t<link rel=\"stylesheet\" href=\"css/tailwind-build.css\">\n</head>\n\n<body>\n\t<section class=\"bg-white dark:bg-gray-900 \">\n\t\t<div class=\"container min-h-screen px-6 py-12 mx-auto lg:flex lg:items-center lg:gap-12\">\n\t\t\t<div class=\"wf-ull lg:w-1/2\">\n\t\t\t\t<p class=\"text-sm font-medium text-blue-500 dark:text-blue-400\">404 error</p>\n\t\t\t\t<h1 class=\"mt-3 text-2xl font-semibold text-gray-800 dark:text-white md:text-3xl\">Page not found</h1>\n\t\t\t\t<p class=\"mt-4 text-gray-500 dark:text-gray-400\">Sorry, the page you are looking for doesn't exist.Here are some helpful links:</p>\n\n\t\t\t\t<div class=\"flex items-center mt-6 gap-x-3\">\n\t\t\t\t\t<a href=\"/\" class=\"flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700\">\n\t\t\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" class=\"w-5 h-5 rtl:rotate-180\">\n\t\t\t\t\t\t\t<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18\" />\n\t\t\t\t\t\t</svg>\n\n\t\t\t\t\t\t<span>Go back</span>\n\t\t\t\t\t</a>\n\n\t\t\t\t\t<a href=\"/\" class=\"w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600\">\n\t\t\t\t\t\tTake me home\n\t\t\t\t\t</a>\n\t\t\t\t</div>\n\t\t\t</div>\n\n\t\t\t<div class=\"relative w-full mt-12 lg:w-1/2 lg:mt-0\">\n\t\t\t\t<img class=\"w-full max-w-lg lg:mx-auto\" src=\"assets/404.svg\" alt=\"\">\n\t\t\t</div>\n\t\t</div>\n\t</section>\n</body>\n\n</html>"
                );
            }
        }

        file_put_contents(
            $directory . "/$view.blade.php",

            "<!DOCTYPE html>\n<html lang='en'>\n<head>\n\t<meta charset='UTF-8'>\n\t<meta name='viewport' content='width=device-width, initial-scale=1.0'>\n\t<title>$view</title>\n\t<link rel=\"stylesheet\" href=\"css/tailwind-build.css\">\n</head>\n<body>\n\t<h1>$view</h1>\n</body>\n</html>"
        );

        exit();
    }

    static function fillSchema(string $filename)
    {
        $path = self::getPath($filename);
        $constructorBlocks = self::getconstructorBlocks($filename);
        $attrs = self::getAttributes($filename);

        $initAttrs = "";
        $gettersAndSetters = "\n";

        $constructorBlocks[2] = explode("}", $constructorBlocks[2])[0] . "\n\t}";

        foreach ($attrs as $attr => $options) {
            $copy = str_replace("$", "", $attr);

            if ($options['modifier'] == 'private') {
                $gettersAndSetters .= self::gettersAndSetters($copy);
            }
            $initAttrs .= "\n\t\t\$this->$copy = \$$copy;" . ($attr != array_key_last($attrs) ? "" : "\n");
        }

        $constructorBlocks[2] = "\n" . $initAttrs . $constructorBlocks[2];
        $constructorBlocks[1] = self::getConstructParams($filename);

        $content = "";

        foreach ($constructorBlocks as $index => $block) {
            $content .= $block . ($index < sizeof($constructorBlocks) - 1 ? " {" : "");
        }

        $content .= self::initModelFunction($filename);
        $content .= $gettersAndSetters . "\n}";

        file_put_contents($path, $content);
        echo ucfirst($filename) . " Model Schema updated.";

        exit();
    }

    private static function getAttributes(string $filename): array
    {
        $types = ["string", "int", "array", "object", "bool", "double", "float"];
        $directory = getdir(__DIR__) . "/../../../models/";

        $iterator = new DirectoryIterator($directory);

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $modelClass = $file->getBasename(".php");
                array_push($types, $modelClass);
            }
        }

        $constructorBlocks = self::getconstructorBlocks($filename);
        $attributes = explode(";", $constructorBlocks[1]);
        $result = [];

        for ($i = 0; $i < sizeof($attributes) - 1; $i++) {
            $line = trim($attributes[$i]);

            $modifier = explode(" ", $line)[0];
            $datatype = "";

            foreach ($types as $type) {
                if (str_contains($line, $type)) {
                    $datatype = $type;
                    $line = str_replace($type, "", $line);
                    break;
                }
            }

            $attrs = explode(",", $line);

            foreach ($attrs as $attr) {
                $attr = trim(str_replace($modifier, "", $attr));
                $result[str_replace(" ", "", $attr)] = [
                    'datatype' => $datatype,
                    'modifier' => $modifier
                ];
            }
        }

        return $result;
    }

    private static function getconstructorBlocks(string $filename): array
    {
        $path = self::getPath($filename);
        $content = file_get_contents($path);

        return explode("{", $content);
    }

    private static function getPath(string $filename)
    {
        $filename = ucfirst($filename) . ".php";
        $directory = getdir(__DIR__) . "/../../../models/";
        return $directory . $filename;
    }

    private static function getConstructParams(string $filename)
    {
        $constructorBlocks = self::getconstructorBlocks($filename);
        $constructor = explode("(", $constructorBlocks[1]);

        $attributes = self::getAttributes($filename);

        $optional_attrs = array_filter(
            $attributes,
            fn($options) => empty($options['datatype'])
        );

        $wtype_attrs = array_filter(
            $attributes,
            fn($options) => !empty($options['datatype'])
        );

        $severalParams = sizeof($attributes) > 4;
        $space = $severalParams ? "\n\t\t" : "";
        $constructor_params =  "";

        foreach ($wtype_attrs as $attr => $options) {
            $constructor_params .= "{$space}{$options['datatype']} {$attr}" . ($attr == array_key_last($wtype_attrs) ? '' : ', ');
        }

        if (!empty($optional_attrs) && !empty($wtype_attrs)) {
            $constructor_params .= ", ";
        }

        foreach ($optional_attrs as $attr => $options) {
            $constructor_params .= "{$space}{$attr} = null" . ($attr == array_key_last($optional_attrs) ? '' : ', ');
        }

        $result = "{$constructor[0]}({$constructor_params}" . ($severalParams ? "\n\t)" : ")");

        return $result;
    }

    private static function gettersAndSetters(string $attribute)
    {
        $getter = "\n\tpublic function get" . ucfirst($attribute) . "() {\n\t\treturn \$this->$attribute;\n\t}\n";
        $setter = "\n\tpublic function set" . ucfirst($attribute) . "(\$$attribute) {\n\t\t\$this->$attribute = \$$attribute;\n\t}\n";

        return $getter . $setter;
    }

    private static function initModelFunction(string $filename)
    {
        $attributes = self::getAttributes($filename);
        $result = "\n\n\tpublic static function init" . ucfirst($filename) . "() {\n\t\tself::migrateModel('";

        foreach ($attributes as $attr => $options) {
            $copy = str_replace("$", "", $attr);

            $result .= match ($options['datatype']) {
                "string" => "\n\t\t\t$copy VARCHAR(255) NOT NULL",
                "int" => "\n\t\t\t$copy INT AUTO_INCREMENT PRIMARY KEY",
                default => "\n\t\t\t$copy <ADD YOUR CONFIGURATION>"
            };
            $result .= ($attr != array_key_last($attributes)) ? "," : "\n\t\t');\n\t}";
        }

        return $result;
    }

    public static function createMiddleware(string $filename)
    {
        $class = ucfirst($filename);
        $directory = getdir(__DIR__) . "/../../../middlewares";

        $folders = explode('/', $filename);

        if (sizeof($folders) > 1) {
            foreach ($folders as $index => $path) {
                if ($index < sizeof($folders) - 1) {
                    $directory .= "/{$path}";
                } else {
                    $class = ucfirst($path);
                }
            }
        }

        if (!is_dir($directory)) {
            mkdir($directory);
        }

        file_put_contents(
            $directory . "/$class.php",
            "<?php\n\nnamespace Src\Middlewares;\n\nuse Src\Core\Request;\nuse Src\Core\Middleware;\n\nclass $class extends Middleware\n{\n\tstatic function runnable(Request \$request, callable \$next)\n\t{\n\t\techo '$class Middleware';\n\t}\n}"
        );

        exit();
    }

    private static function camelToDashed($string)
    {
        $words = preg_split("/(?=[A-Z])/", $string);

        $route = "";

        for ($i = 1; $i < sizeof($words); $i++) {
            $route .= $words[$i] . (array_key_last($words) !== $i ? "-" : "");
        }

        return strtolower($route);
    }
}
