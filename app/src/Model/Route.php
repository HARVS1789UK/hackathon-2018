<?php

namespace HARVS1789UK\Hackathon;

use HARVS1789UK\Hackathon\Event;
use SilverStripe\ORM\DataObject;
use HARVS1789UK\Hackathon\Waypoint;

class Route extends DataObject {
    
    private static $table_name = "Route";

    private static $db = [
        'Name'              => 'Varchar',
        'StartLatitude'     => 'Varchar',
        'StartLongitude'    => 'Varchar',
        'EndLatitude'       => 'Varchar',
        'EndLongitude'      => 'Varchar'
    ];

    private static $has_one = [
        'Event' => Event::class
    ];

    private static $has_many = [
        'Waypoints' => Waypoint::class
    ];

    private static $summary_fields = [
        'Name'  => 'Name'
    ];
}
