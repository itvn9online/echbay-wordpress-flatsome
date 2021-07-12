<?php

class BaseModelWgr {
    public function __construct() {}

    public function a() {
        echo __CLASS__ . ':' . __FUNCTION__ . ':' . __LINE__ . '<br>' . "\n";
    }
}