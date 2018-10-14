<?php

namespace HARVS1789UK\Hackathon;

use HARVS1789UK\Hackathon\Route;
use SilverStripe\ORM\DataObject;

class Waypoint extends DataObject {

    private static $table_name = "Waypoint";

    private static $db = [
        'Sort'      => 'Int',
        'Longitude' => 'Varchar',
        'Latitude'  => 'Varchar'
    ];

    private static $has_one = [
        'Route' => Route::class
    ];

    private static $summary_fields = [
        'getPosition'   => 'Position',
        'Sort'          => 'Order'
    ];

    private static $default_sort = '"Sort" ASC';

    public function getPosition()
    {
        return $this->Longitude . ', ' . $this->Latitude;
    }
}
