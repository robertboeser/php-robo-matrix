<?php
namespace Robo\RoboMatrix\Core;

use Robo\RoboHttp\Request;

class Discovery extends Base {

    function homeserver($user_id) {
        $parts = explode(':', $user_id);
        if(empty($parts[1])) return false;

        $url = "https://{$parts[1]}";
        $req = new Request($url);
        $res = $req->get('/.well-known/matrix/client');
        $json = json_decode($res);

        return @$json?->{'m.homeserver'};
    }

    function baseUrl($user_id) {
        $home = $this->homeserver($user_id);
        if(!$home) return false;
        $base = $home?->base_url;
        if(!$base) return false;
        $base = trim($base, '/');

        if(static::state) static::state->set('api', $base);

        return $base;
    }
}
