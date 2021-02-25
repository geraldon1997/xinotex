<?php
namespace App\Core;

use App\Models\Role;

class Populate extends QueryBuilder
{
    public static function rolesTable()
    {
        return QueryBuilder::insert(Role::$table, ['admin','moderator','user']);
    }
}
