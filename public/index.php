<?php
# Root path
define('ROOT', dirname(__DIR__));
define('APP', ROOT."/app");
define('VENDOR', ROOT."/vendor");

# Load the autoloader
require VENDOR."/autoload.php";

# Load the router
$router = new App\Core\Router();
$router->match();

