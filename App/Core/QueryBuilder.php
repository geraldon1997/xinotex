<?php
namespace App\Core;

class QueryBuilder extends Gateway
{
    public static function columns($table)
    {
        $query = "SHOW COLUMNS FROM $table";
        $result = self::fetch($query);

        $columns = [];
        for ($i=0; $i < count($result); $i++) {
            array_push($columns, $result[$i]['Field']);
        }
        array_shift($columns);
        return $columns;
    }

    public static function create($table, $values)
    {
        $query = "CREATE TABLE IF NOT EXISTS $table ($values) ENGINE=INNODB";
        $result = self::execute($query);

        return $result;
        // return $query;
    }

    public static function insert($table, $values)
    {
        $columns = array_keys($values);
        $values = array_values($values);
        $cols = implode('`, `', $columns);
        $vals = implode("', '", $values);

        $query = "INSERT INTO $table (`$cols`) VALUES ('$vals')";
        $result = self::execute($query);

        return $result;
        // return $query;
    }

    public static function update($table, $data, $col, $val)
    {
        $query = "UPDATE $table SET $data WHERE $col = '$val' ";
        $result = self::execute($query);

        return $result;
    }

    public static function delete($table, $col, $val)
    {
        $query = "DELETE FROM $table WHERE $col = '$val' ";
        $result = self::execute($query);

        return $result;
    }

    public static function all($table)
    {
        $query = "SELECT * FROM $table";
        $result = self::fetch($query);

        return $result;
    }

    public static function find($table, $col, $val)
    {
        $query = "SELECT * FROM $table WHERE $col = '$val'";
        $result = self::fetch($query);

        return $result;
        // return $query;
    }

    public static function findSingle($table, $col, $val)
    {
        $query = "SELECT * FROM $table WHERE $col = '$val' LIMIT 1";
        $result = self::fetch($query);

        return $result;
    }

    public static function findMultiple($table, $queries)
    {
        $query = "SELECT * FROM $table WHERE $queries";
        $result = self::fetch($query);

        return $result;
        // return $query;
    }

    public static function exists($table, $col, $val)
    {
        $query = "SELECT * FROM $table WHERE $col = '$val' ";
        $result = self::check($query);
        
        return $result;
    }
}
