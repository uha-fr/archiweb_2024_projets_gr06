<?php

/**
 * Application Entry Point
 *
 * Main entry point for the web application.
 * It initializes essential settings, autoloads classes, environment variables
 * and handles the incoming HTTP request through the router.
 *
 * @author gr06
 * @version 1.0
 */

use Manger\Router;
use Dotenv\Dotenv;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'vendor/autoload.php';


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$r = new Router();
$r->manageRequest();
