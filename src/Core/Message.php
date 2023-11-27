<?php
namespace Robo\RoboMatrix\Core;

use Robo\RoboHttp\Request;

class Message extends Base {

    function send($roomId, $message) {
        $s = static::$state;
        if(!$s) return false;

        $req = new Request($s->api);
        $dat = [
            'msgtype' => 'm.text',
            'body' => $message
        ];
        $hdr = [
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$s->access_token}"
        ];
        $res = $req->post("/_matrix/client/v3/rooms/$roomId/send/m.room.message", $hdr, json_encode($dat));
        return json_decode($res);
    }

}
