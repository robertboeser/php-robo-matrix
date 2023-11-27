<?php
namespace Robo\RoboMatrix\Core;

use Robo\RoboHttp\Request;

class Sync extends Base {

    function sync() {
        $s = static::$state;
        if(!$s) return false;

        $req = new Request($s->api);
        $hdr = [
            'Authorization' => "Bearer {$s->access_token}"
        ];
        $res = $req->get('/_matrix/client/v3/sync', $hdr);
        //file_put_contents(__DIR__.'/../../data/sync.json', $res);
        return json_decode($res);
    }

}
