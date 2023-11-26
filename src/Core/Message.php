<?php
namespace Robo\RoboMatrix\Core;

use Robo\RoboHttp\Request;

class Message extends Base {

    function send($roomId, $message) {
        $access = @static::$state?->apiAccess();
        if(!$access) return false;

        $req = new Request($access->api);
        $dat = [
            'msgtype' => 'm.text',
            'body' => $message
        ];
        $hdr = [
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$access->access_token}"
        ];
        $res = $req->post("/_matrix/client/v3/rooms/$roomId/send/m.room.message", $hdr, json_encode($dat));
        return json_decode($res);
    }

}
