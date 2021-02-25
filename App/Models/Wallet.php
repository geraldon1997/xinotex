<?php
namespace App\Models;

use App\Core\QueryBuilder;

class Wallet extends QueryBuilder
{
    public static $table = "wallets";

    public static function details()
    {
        $userid = User::userid($_SESSION['email']);
        return self::findSingle(self::$table, 'user_id', $userid);
    }
}
