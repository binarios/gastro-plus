<?php
# Root path
define('ROOT', dirname(__DIR__));
define('APP', ROOT."/app");
define('VENDOR', ROOT."/vendor");

# Load the autoloader
require VENDOR."/autoload.php";

# Load the environment variables
$dotenv = new App\Core\Dotenv;
$dotenv->load();

# Load the router
$router = new App\Core\Router;
$router->match();

