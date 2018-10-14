<?php

namespace HARVS1789UK\Hackathon;

use \PageController;
use HARVS1789UK\Hackathon\Event;
use HARVS1789UK\Hackathon\Route;
use HARVS1789UK\Hackathon\Waypoint;
use SilverStripe\Security\Security;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;

class EventsPageController extends PageController implements PermissionProvider {

    private static $allowed_actions = [
        'addEvent'       => 'REPORT_HIGHWAY_EVENTS',
        'reportEvent'    => 'REPORT_HIGHWAY_EVENTS',
        'viewEvents'     => 'VIEW_HIGHWAY_EVENTS'
    ];

    private static $url_handlers = [
        'add'       => 'addEvent',
        'report'    => 'reportEvent',
        'view'      => 'viewEvents'
    ];

    public function providePermissions() {

        return array(
            "VIEW_HIGHWAY_EVENT_PAGES"  => [
                'name'      => "Access the 'Highway Events' area",
                'category'  => 'Highway Events',
                'help'      => null,
                'sort'      => 10
            ],
            "VIEW_HIGHWAY_EVENTS"       => [
                'name'      => "View 'Highway Events'",
                'category'  => 'Highway Events',
                'help'      => null,
                'sort'      => 11
            ],
            "REPORT_HIGHWAY_EVENTS"     => [
                'name'      => "Report new 'Highway Events'",
                'category'  => 'Highway Events',
                'help'      => null,
                'sort'      => 12
            ]
        );

    }

    public function init() {

        parent::init();

        $response = $this->getResponse();
        $response->addHeader("X-Robots-Tag", "noindex, nofollow");

        if(!Permission::check("VIEW_HIGHWAY_EVENT_PAGES")) {
            Security::permissionFailure();
            return;
        }

    }

    public function index() {
        return $this->viewEvents();
    }

    public function addEvent()
    {
        $request = $this->getRequest();
        $data = $request->postVars();
        
        $event = new Event();
        if (isset($data['Category']) && $data['Category'] === 'planned-closure') {
            $event->Type = 'planned';
        } else {
            $event->Type = 'current';
        }
        $event->Severity = (isset($data['Severity'])) ? $data['Severity'] : null;
        $event->Category = (isset($data['Category'])) ? $data['Category'] : null;
        $event->Comment = (isset($data['Comment'])) ? $data['Comment'] : null;
        $event->Latitude = (isset($data['Latitude'])) ? $data['Latitude'] : null;
        $event->Longitude = (isset($data['Longitude'])) ? $data['Longitude'] : null;
        $event->Start = (isset($data['Start'])) ? preg_replace('/[T]/', ' ', $data['Start']) : null;
        $event->End = (isset($data['End'])) ? preg_replace('/[T]/', ' ', $data['End']) : null;
        $event->write();

        if (isset($data['Route']) && !empty($data['Route'])) {

            $r = $data['Route'];
            $route = new Route();
            $route->Name = (isset($r['Name'])) ? $r['Name'] : null;
            $route->StartLatitude = $r['Start']['Latitude'];
            $route->StartLongitude = $r['Start']['Longitude'];
            $route->EndLatitude = $r['End']['Latitude'];
            $route->EndLongitude = $r['End']['Longitude'];
            $route->EventID = $event->ID;
            $route->write();
            
            // Create start waypoint
            $wp = new Waypoint();
            $wp->Latitude = $r['Start']['Latitude'];
            $wp->Longitude = $r['Start']['Longitude'];
            $wp->Sort = 0;
            $wp->RouteID = $route->ID;
            $wp->write();

            // Create all intermidiary waypoints
            $i = 1;
            foreach($r['Waypoints'] as $waypoint) {
                // Create waypoint
                $wp = new Waypoint();
                $wp->Latitude = $waypoint['Latitude'];
                $wp->Longitude = $waypoint['Longitude'];
                $wp->Sort = $i;
                $wp->RouteID = $route->ID;
                $wp->write();
                // Increase counter
                $i++;
            }

            // Create end waypoint
            $wp = new Waypoint();
            $wp->Latitude = $r['End']['Latitude'];
            $wp->Longitude = $r['End']['Longitude'];
            $wp->Sort = $i;
            $wp->RouteID = $route->ID;
            $wp->write();

        }

        return $this->renderWith([
            'Event_Submitted',
            'Page'
        ]);
    }

    public function reportEvent()
    {
        return $this->renderWith([
            'Event_Report',
            'Page'
        ]);
    }

    public function viewEvents()
    {
        return $this->renderWith([
            'Event_View',
            'Page'
        ]);
    }

}
