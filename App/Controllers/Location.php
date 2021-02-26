<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Location as ModelsLocation;
use HolidayAPI\Client as Holiday;

class Location extends Controller
{
    public $key = '586da4c9-51d9-40ea-808d-b498e8a83ad4';
    public $holiday;

    public function __construct()
    {
        $this->holiday = new Holiday(['key' => $this->key]);
    }

    public static function countries()
    {
        $countries = ModelsLocation::all(ModelsLocation::$table);
        return $countries;
    }

    public function addcountries()
    {
        //
    }
}
