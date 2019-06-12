<?php

interface MessagesInterface {
    public function push($string, $type);
    public static function display();
    public static function clear();
}