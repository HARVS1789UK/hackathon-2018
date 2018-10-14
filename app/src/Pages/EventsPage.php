<?php

namespace HARVS1789UK\Hackathon;

use \Page;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;

class EventsPage extends Page {

    public function canView($member = null)
    {
        if (!isset($member)) {
            $member = Member::currentUser();
        }
        return Permission::checkMember($member, 'VIEW_HIGHWAY_EVENT_PAGES');
    }
}