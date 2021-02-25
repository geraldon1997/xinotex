<?php
namespace App\Models;

use App\Core\QueryBuilder;

class Profile extends QueryBuilder
{
    public static $table = "profiles";

    public static function authUser()
    {
        $userid = User::userid($_SESSION['email']);
        $profile = self::find(Profile::$table, 'user_id', $userid);
        if (!$profile) {
            return false;
        }
        return $profile[0];
    }
}
