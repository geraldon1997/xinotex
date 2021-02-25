<?php
namespace App\Models;

use App\Core\QueryBuilder;

class User extends QueryBuilder
{
    public static $table = 'users';

    public static function userid($email)
    {
        $user = QueryBuilder::findSingle(self::$table, 'email', $email);
        return $user[0]['id'];
    }

    public static function userRole()
    {
        $roleid = User::findSingle(User::$table, 'email', $_SESSION['email'])[0]['role_id'];
        return Role::findSingle(Role::$table, "id", $roleid)[0]['role'];
    }

    public static function users($roleid, $is_active)
    {
        $users = [];
        $auths = Auth::findMultiple(Auth::$table, " is_active = $is_active AND user_id != 49 ");

        foreach ($auths as $key) {
            $userid = $key['user_id'];
            $user = User::findMultiple(User::$table, "id = $userid AND role_id = $roleid");
            foreach ($user as $u) {
                array_push($users, ['auth' => $key, 'user' => $u]);
            }
        }
                
        return $users;
    }

    public static function isMember()
    {
        return User::userRole() === 'member' ? true : false;
    }

    public static function isModerator()
    {
        return User::userRole() === 'moderator' ? true : false;
    }

    public static function isAdmin()
    {
        return User::userRole() === 'admin' ? true : false;
    }

    public static function hasProfile()
    {
        $userid = User::userid($_SESSION['email']);
        $profile = Auth::findSingle(Auth::$table, 'user_id', $userid);

        if ($profile[0]['is_active']) {
            return true;
        } else {
            return false;
        }
    }

    public static function ref($email)
    {
        return self::find(User::$table, 'email', $email)[0]['ref'];
    }
}
