<?php
namespace App\Models;

use App\Core\QueryBuilder;

class Referral extends QueryBuilder
{
    public static $table = 'referrals';

    public static function myReferrals()
    {
        $userid = User::userid($_SESSION['email']);
        return Referral::find(Referral::$table, 'referrer', $userid);
    }

    public static function investments()
    {
        //
    }
}
