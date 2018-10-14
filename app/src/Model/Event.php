<?php

namespace HARVS1789UK\Hackathon;

use HARVS1789UK\Hackathon\Route;
use SilverStripe\ORM\DataObject;

class Event extends DataObject {
    
    private static $table_name = "Event";

    private static $db = [
        'Type'      => 'Varchar',
        'Category'  => 'Varchar',
        'Severity'  => 'Varchar',
        'Longitude' => 'Varchar',
        'Latitude'  => 'Varchar',
        'Start'     => 'DBDatetime',
        'End'       => 'DBDatetime'
    ];

    private static $has_many = [
        'Routes' => Route::class
    ];

    private static $summary_fields = [
        'Category'      => 'Cateogry',
        'Severity'      => 'Severity',
        'getPosition'   => 'Position',
        'Routes.Count'  => 'Affected Routes'
    ];

    private static $searchable_fields = [
        'Category',
        'Severity'
    ];

    public function getPosition()
    {
        return $this->Longitude . ', ' . $this->Latitude;
    }
}