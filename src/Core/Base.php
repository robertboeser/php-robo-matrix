<?php
namespace Robo\RoboMatrix\Core;

use Robo\RoboMatrix\Util\State;
//use Robo\RoboHttp\Request;


class Base {
    protected static State $state;
    //protected static Request $request;

    static function setState(State $state) {
        static::$state = $state;
    }

    static function setRequest(Request $request) {
        static::$request = $request;
    }
}
