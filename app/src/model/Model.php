<?php

class Model {
    protected static $db;

    public static function setDb($db) {
        self::$db = $db;
    }

    // public function save() {}
}
