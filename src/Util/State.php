<?php
namespace Robo\RoboMatrix\Util;

class State {
    protected $storage;

    function __construct($storage_file) {
        $this->storage = $storage_file;
    }

    function read() {
        $json = file_get_contents($this->storage);
        if(!$json) $json = '{}';
        return json_decode($json);
    }

    function write($obj) {
        $json = json_encode($obj, JSON_PRETTY_PRINT);
        file_put_contents($this->storage, $json);
    }

    function get($key) {
        $obj = $this->read();
        return $obj?->{$key};
    }

    function set($key, $val) {
        $obj = $this->read();
        $obj->{$key} = $val;
        $this->write($obj);
    }

    function apiAccess() {
        $obj = $this->read();
        if(empty($obj->api) || empty($obj->access_token)) return null;
        return json_decode(json_encode([
            'api'           => $obj->api,
            'access_token'  => $obj->access_token
        ]));
    }

}
