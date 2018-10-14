<?php

use HARVS1789UK\Hackathon\Event;
use SilverStripe\Admin\ModelAdmin;

class EventAdmin extends ModelAdmin 
{

    private static $managed_models = [
        Event::class
    ];

    private static $url_segment = 'highway-events';

    private static $menu_title = 'Highway Events';
}