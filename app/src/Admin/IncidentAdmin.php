<?php

use SilverStripe\Admin\ModelAdmin;
use HARVS1789UK\Hackathon\Incident;

class IncidentAdmin extends ModelAdmin 
{

    private static $managed_models = [
        Incident::class
    ];

    private static $url_segment = 'incidents';

    private static $menu_title = 'Incidents';
}