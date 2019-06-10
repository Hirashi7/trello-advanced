<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

define('DEBUG',true);

define('API_KEY', 'd664b85686c166a98f1292baad1e19eb');
define('API_TOKEN', 'fae124d38f4a70193b073be6d72358a228c8129fd9cdf68f7a5181ff6ab5a8b1');

require "vendor/autoload.php";

$app = new App(new DbConnection());

$bootstrap = new Bootstrap($app, new Router());