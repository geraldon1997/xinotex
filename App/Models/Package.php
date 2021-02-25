<?php
namespace App\Models;

use App\Core\QueryBuilder;

class Package extends QueryBuilder
{
    public static $table = "packages";

    public static function allPackages()
    {
        return self::all(Package::$table);
    }

    public static function package($packageid)
    {
        return self::findSingle(Package::$table, 'id', $packageid);
    }
}
