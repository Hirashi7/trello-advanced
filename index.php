<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

define('DEBUG',true);

require "vendor/autoload.php";

$app = new App(new DbConnection());

$bootstrap = new Bootstrap($app, new Router());