<?php

class PostModelWgr extends BaseModelWgr {
    function __construct() {
        parent::__construct();
    }

    function test() {
        echo __CLASS__ . ':' . __FUNCTION__ . ':' . __LINE__ . '<br>' . "\n";
    }
}