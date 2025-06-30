<?php

namespace Src\Core;

use DirectoryIterator;
use PDO;
use PDOException;

use function Src\Core\Utils\Helpers\getdir;

class Database
{
    private PDO | bool $pdo;

    public function __construct()
    {
        $config = require getdir(__DIR__) . '/../config/db.config.php';

        if (!empty($config['dbname'])) {
            $this->pdo = self::getPDOInstance();
        } else {
            $this->pdo = false;
        }
    }

    private static function getPDOInstance(): PDO | bool
    {
        try {
            $config = require getdir(__DIR__) . '/../config/db.config.php';

            $dsn = "mysql:" . http_build_query($config, "", ";");

            return new PDO($dsn, $config["user"], $config["password"], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            if ($e->getCode() === 2002) {
                self::alert("Database down: Try starting your database server.");
            }
            if ($e->getCode() == 1049) {
                self::alert("Database Error: Unknown database {$config['dbname']}.");
            }

            return false;
        }
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public static function query(string $query, array $params = []): array
    {
        $pdo = self::getPDOInstance();

        $statement = $pdo->prepare($query);

        $statement->execute($params);

        return $statement->fetchAll();
    }

    protected static function getProperties(Model $model): array
    {
        $attributes = array_filter(
            (array) $model,
            fn($attr) => $attr !== null
        );

        $keys = array_map(
            fn($attr) => trim(str_replace(get_class($model), "", $attr)),
            array_keys($attributes)
        );

        $values = array_values($attributes);
        $attributes = [];

        for ($i = 0; $i < sizeof($keys); $i++) {
            $attributes[$keys[$i]] = $values[$i];
        }

        return $attributes;
    }

    private static function alert(string $msg)
    {
        echo "<script>alert('{$msg}')</script>";
    }

    public function save(): void
    {
        $pdo = $GLOBALS['database']->getPDO();

        if (!$pdo) {
            throw new PDOException("Uninitialized Database Name. Make sure you have the right database name in src/config/db.config.php file.", 1391992);
        }

        $attributes = self::getProperties($this);
        $table = str_replace(
            "src\\models\\",
            "",
            strtolower(get_called_class()) . "s"
        );
        $query = "insert into `$table` (";

        $attach_attributes = function (string $prep = "")
        use (&$attributes, &$query) {
            $tag = $prep ? "" : "`";
            foreach (array_keys($attributes) as $key) {
                $query .= $tag . $prep . $key . $tag . ($key != array_key_last($attributes) ? ", " : ") ");
            }
        };

        $attach_attributes();
        $query .= "values (";
        $attach_attributes(":");

        $statement = $pdo->prepare($query);
        $statement->execute($attributes);
    }

    public static function migrateModel(string $config): bool
    {
        $pdo = self::getPDOInstance();
        $table = str_replace(
            "src\\models\\",
            "",
            strtolower(get_called_class()) . "s"
        );


        try {
            $query = "CREATE TABLE `{$table}` ( {$config} )";
            $pdo->exec($query);
            echo "\nIniatilizing...\nDatabase initialization process complete.\nTable creation successfully executed.\n";
            return true;
        } catch (PDOException $e) {
            if ($e->getCode() === "42S01") {
                $dbname = (require getdir(__DIR__) . '/../config/db.config.php')['dbname'];
                return self::alterTable($pdo, $config, [
                    'table' => $table,
                    'dbname' => $dbname
                ]);
            }

            echo "\n{$e->getMessage()}\n";

            return false;
        }
    }

    private static function alterTable(PDO $pdo, string $table_config, array $params): bool
    {
        try {
            $config = explode(",", $table_config);
            // ALTER TABLE `records` CHANGE `title` `title` VARCHAR(10) NOT NULL;
            $query = "SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = :dbname AND table_name = :table;";

            $statement = $pdo->prepare($query);
            $statement->execute($params);

            $table_size = $statement->fetch()['COUNT(*)'];

            $query = "ALTER TABLE `{$params['table']}`";

            echo "\nUpdating Table...\n";

            if ($table_size === sizeof($config)) {
                for ($i = 0; $i < sizeof($config); $i++) {
                    $column = trim(explode(' ', $config[$i])[0]);
                    $column_config = str_replace($column, '', trim($config[$i]));

                    if (!str_contains($column_config, "PRIMARY KEY")) {
                        $query .= " CHANGE `{$column}` `{$column}`{$column_config}" . ($i < sizeof($config) - 1 ? "," : ";");
                    }
                }

                $statement = $pdo->prepare($query);
                $statement->execute();
                echo "Table updated successfully.\n";
                return true;
            }

            $pdo->exec("DROP TABLE `{$params['table']}`");

            return self::migrateModel($table_config);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function extendModel(string $config): bool
    {
        try {
            echo "\nExtending columns...";
            $pdo = self::getPDOInstance();
            $table = str_replace(
                "src\\models\\",
                "",
                strtolower(get_called_class()) . "s"
            );
            $query = "ALTER TABLE `{$table}` ADD " . trim($config);

            $pdo->exec($query);

            echo "\nColumns successfully extended.\n";
            return true;
        } catch (PDOException $e) {
            echo "\nExtend Error: {$e->getMessage()}";
            return false;
        }
    }

    private static function getPrimaryKey($prevData)
    {
        foreach ($prevData as $key => $val) {
            if (
                $key === 'id' ||
                (str_contains(strtolower($key), 'id')
                    && str_contains(strtolower($key), strtolower(get_called_class()))
                )
            ) {
                return $key;
            }
        }

        return array_key_first($prevData);
    }

    public static function initModels()
    {
        include_once getdir(__DIR__) . '/Model.php';
        $modelsPath = getdir(__DIR__) . "/../models";
        $iterator = new DirectoryIterator($modelsPath);

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $modelClass = $file->getBasename(".php");
                include_once "{$modelsPath}/{$modelClass}.php";
                eval("Src\\Models\\{$modelClass}::init{$modelClass}();");
            }
        }
    }

    public function update(...$params): void
    {
        $pdo = $GLOBALS['database']->getPDO();

        if (!$pdo) {
            throw new PDOException("Uninitialized Database Name. Make sure you have the right database name in src/config/db.config.php file.", 1391992);
        }

        $prevData = self::getProperties($this);
        $primaryKey = self::getPrimaryKey($prevData);

        $updatedData = [...$prevData, ...$params];

        $this->__construct(...$updatedData);

        $table = str_replace(
            "src\\models\\",
            "",
            strtolower(get_called_class()) . "s"
        );
        $query = "UPDATE `$table` SET ";

        foreach ($updatedData as $key => $value) {
            $query .= "`$key` = :$key" . ($key != array_key_last($updatedData) ? ", " : " ");
        }

        $query .= " WHERE `$table`.`{$primaryKey}` = :{$primaryKey}";

        $statement = $pdo->prepare($query);

        $statement->execute([...$updatedData, $primaryKey => $updatedData[$primaryKey]]);
    }

    public function delete(): void
    {
        $pdo = $GLOBALS['database']->getPDO();

        if (!$pdo) {
            throw new PDOException("Uninitialized Database Name. Make sure you have the right database name in src/config/db.config.php file.", 1391992);
        }

        $modelData = self::getProperties($this);
        $primaryKey = self::getPrimaryKey($modelData);
        $table = str_replace(
            "src\\models\\",
            "",
            strtolower(get_called_class()) . "s"
        );
        $query = "DELETE FROM `$table` WHERE `$table`.`{$primaryKey}` = :{$primaryKey}";

        $statement = $pdo->prepare($query);
        $statement->execute([$primaryKey => $modelData[$primaryKey]]);
    }
}
