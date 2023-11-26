<?php
namespace Robo\RoboMatrix\Core;

use Robo\RoboHttp\Request;

class Sync extends Base {

    function sync() {
        $access = @static::state?->apiAccess();
        if(!$access) return false;

        $req = new Request($access->api);
        $hdr = [
            'Authorization' => "Bearer {$access->access_token}"
        ];
        $res = $req->get('/_matrix/client/v3/sync', $hdr);
        //file_put_contents(__DIR__.'/../../data/sync.json', $res);
        return json_decode($res);
    }

}
