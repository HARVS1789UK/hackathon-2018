<?php

namespace HARVS1789UK\Hackathon;

use SilverStripe\ORM\DataObject;

class Incident extends DataObject {

    private static $table_name = 'Incident';

    private static $db = [
        'Ref' => 'Varchar',
        'IFID' => 'Int',
        'OccuredAt1' => 'DBDatetime',
        'OccuredAt2' => 'DBDatetime',
        'ReportedAt' => 'DBDatetime',
        'Parish' => 'Varchar',
        'LightConditions' => 'Varchar',
        'NoOfCasualties' => 'Int',
        'NoOfVehicles' => 'Int',
        'Weather' => 'Varchar',
        'RoadSurfaceConditions' => 'Varchar',
        'SpeedLimit' => 'Int'
    ];

    private static $summary_fields = [
        'Ref'           => 'Ref',
        'Parish'        => 'Parish',
        'OccuredAt1'    => 'Occured At',
        'Weather'       => 'Weather Conds.'
    ];

    private static $searchable_fields = [
        'Ref',
        'Parish',
        'OccuredAt1'
    ];

}