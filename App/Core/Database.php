<?php
namespace App\Core;

use mysqli;

class Database
{
    public static function open()
    {
        $con = new mysqli('localhost', 'root', '', 'hynet');

        if (!$con) {
            return "Error connecting to database, please contact sysadmin ".$con->error;
        }

        return $con;
    }

    public static function close()
    {
        return self::open()->close();
    }
}
