<?php
namespace Robo\RoboMatrix\Core;

use Robo\RoboHttp\Request;

class Login extends Base {

    function password($usr, $pwd) {
        $api = static::$state?->get('api');
        if(!$api) return false;

        $req = new Request($api);
        $dat = [
            'type' => 'm.login.password',
            'identifier' => [
              'type' => 'm.id.user',
              'user' => $usr,
            ],
            'password' => $pwd
        ];
        $hdr = ['Content-Type' => 'application/json'];
        $res = $req->post('/_matrix/client/v3/login', $hdr, json_encode($dat));
        $dat = json_decode($res);

        static::$state->set('access_token', $dat->access_token);
        static::$state->set('device_id', $dat->device_id);

        return $dat;
    }

    function getFlows() {
        $api = static::$state?->get('api');
        if(!$api) return false;

        $req = new Request($api);
        $res = $req->get('/_matrix/client/v3/login');
        return json_decode($res);
    }
}
