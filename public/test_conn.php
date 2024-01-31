<?php

use Config\Database;
// Include the database configuration file
require_once '../Config/Database.php';

// Create a new instance of the database class
$db = new Database();

// If a connection was successfully made, the success message will be displayed
// Otherwise, the error message will be echoed from the catch block in Database.php
