<?php
namespace App\Models;

use App\Core\QueryBuilder;

class Withdrawal extends QueryBuilder
{
    public static $table = "withdrawals";

    public static function totalWithdrawal()
    {
        $userid = User::userid($_SESSION['email']);
        $withdrawal = self::findMultiple(self::$table, "user_id = $userid AND status = 1");
        return count($withdrawal);
    }
}
