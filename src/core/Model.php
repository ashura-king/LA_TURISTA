<?php

namespace Src\Core;

abstract class Model extends Database
{
    public static function find(array $param)
    {
        $table = str_replace(
            "src\\models\\",
            "",
            strtolower(get_called_class())
        );
        $query = "SELECT * FROM `{$table}s`";

        $query .= " WHERE";

        foreach ($param as $key => $value) {
            $query .= ($key !== array_key_first($param) ? " AND " : " ") . "`{$table}s`.`{$key}` = :{$key}";
        }

        $data = parent::query($query, [...$param]);

        if (empty($data) && !empty($param)) {
            return null;
        }

        if (sizeof($data) === 1) {
            return self::mapper($data[0]);
        }

        return self::mapper($data);
    }

    public static function all(array $columns = [])
    {
        $table = str_replace(
            "src\\models\\",
            "",
            strtolower(get_called_class())
        );
        $query = empty($columns) ? "SELECT * FROM `{$table}s`" : "SELECT " . implode(", ", $columns) . " FROM `{$table}s`";

        if (!empty($columns)) {
            if (sizeof($columns) == 1) {
                return array_map(
                    fn($column): string =>  $column[$columns[0]],
                    parent::query($query)
                );
            }

            return parent::query($query);
        }

        return self::mapper(parent::query($query));
    }


    public static function findById(int | string $id)
    {
        $table = str_replace(
            "src\\models\\",
            "",
            strtolower(get_called_class())
        );
        $query = "select * from {$table}s where id = :id";

        $data = parent::query($query, ["id" => $id]);

        return empty($data) ? null : self::mapper($data[0]);
    }

    private static function mapper(array $data)
    {
        $class = get_called_class();

        if (array_is_list($data)) {
            return array_map(
                fn($dt) => new $class(...$dt),
                $data
            );
        }

        return new $class(...$data);
    }
}
