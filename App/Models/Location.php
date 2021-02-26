<?php
namespace App\Models;

use App\Core\QueryBuilder;

class Location extends QueryBuilder
{
    public static $table = 'countries';

    public static function countries()
    {
        return self::all('countries');
    }
    
    public static function countryId($countryid)
    {
        // return self::
    }

    public static function countryISO()
    {
        //
    }

    public static function countryName()
    {
        //
    }

    public static function countryNicename()
    {
        //
    }

    public static function countryNumcode()
    {
        //
    }

    public static function phoneCode($countryid)
    {
        return self::findSingle(self::$table, 'id', $countryid)[0]['phonecode'];
    }
}
