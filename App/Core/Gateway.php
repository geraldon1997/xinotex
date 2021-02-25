<?php
namespace App\Core;

class Gateway
{
    public static function execute($query)
    {
        $result = Database::open()->query($query);
        Database::close();
        
        if (!$result) {
            return 0;
        }
        return $result;
    }

    public static function fetch($query)
    {
        $data = [];

        $result = Database::open()->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                array_push($data, $row);
            }
            Database::close();
            return $data;
        }
        Database::close();
        return 0;
    }

    public static function check($query)
    {
        $result = Database::open()->query($query);

        Database::close();
        return $result->num_rows;
    }
}
