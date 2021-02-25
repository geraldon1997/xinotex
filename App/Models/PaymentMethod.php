<?php
namespace App\Models;

use App\Core\QueryBuilder;

class PaymentMethod extends QueryBuilder
{
    public static $table = 'payment_methods';

    public static function allMethods()
    {
        return self::all(self::$table);
    }
}
