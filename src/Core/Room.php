<?php
namespace Robo\RoboMatrix\Core;

use Robo\RoboHttp\Request;

class Room extends Base {
    protected $events;

    function getRoomIDs() {
        $rooms = @$this->events?->join;
        if(!$rooms) return [];
        return array_keys(get_object_vars($rooms));
    }

    function joinRooms($users) {
        $access = @static::state?->apiAccess();
        if(!$access) return false;
        // join invited rooms if creator and member is in users
        $req = new Request($access->api);
        $hdr = [
            'Authorization' => "Bearer {$access->access_token}"
        ];

        $invites = @$this->events?->invite;
        if(!$invites) return [];

        $list = [];

        foreach($invites as $room_id => $invite) {
            $events = $invite?->invite_state?->events;
            if(!$this->checkCreator($events, $users)) continue;
            if(!$this->checkMember($events, $users)) continue;

            $res = $req->post("/_matrix/client/v3/rooms/$room_id/join", $hdr);
            $rid = json_decode($res)?->room_id;
            if($rid) $list[] = $rid;
        }
        return $list;
    }

    protected function checkCreator($events, $users) {
        // creator must be in users
        foreach($events as $event) {
            if($event->type !== 'm.room.create') continue;
            if(in_array($event->content->creator, $users)) return true;
        }
        return false;
    }

    protected function checkMember($events, $users) {
        // creator must be in users
        $result = false;
        foreach($events as $event) {
            if($event->type !== 'm.room.member') continue;
            if($event->content->membership !== 'join') continue;
            if(in_array($event->state_key, $users)) {
                $result = true;     // merken, dass mindestens ein Mitglied in users ist
            } else {
                return false;       // aussteigen, wenn ein Mitglied nicht in users
            }
        }
        return $result;
    }

    function setEvents($events) {
        $this->events = $events;
    }
}
