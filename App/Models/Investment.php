<?php
namespace App\Models;

use App\Core\QueryBuilder;

class Investment extends QueryBuilder
{
    public static $table = "investments";

    public static function completed($userid)
    {
        return Investment::findMultiple(Investment::$table, "user_id = $userid AND is_active = 1 AND is_completed = 1");
    }

    public static function pending($userid)
    {
        return Investment::findMultiple(Investment::$table, "user_id = $userid AND is_active = 0 AND is_completed = 0");
    }

    public static function active($userid)
    {
        return Investment::findMultiple(Investment::$table, "user_id = $userid AND is_active = 1 AND is_completed = 0");
    }

    public static function total()
    {
        $userid = User::userid($_SESSION['email']);
        $investments = Investment::find(Investment::$table, 'user_id', $userid);
        return count($investments);
    }

    public static function current()
    {
        $userid = User::userid($_SESSION['email']);
        return Investment::findMultiple(Investment::$table, "user_id = $userid AND is_active = 1 ORDER BY id DESC LIMIT 1");
    }

    public static function usdtobtc($amount)
    {
        return file_get_contents(USD_TO_BTC.$amount);
    }

    public static function investments($userid)
    {
        return Investment::find(Investment::$table, 'user_id', $userid);
    }
}
