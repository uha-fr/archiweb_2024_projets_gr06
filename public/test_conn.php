<?php

use Config\Database;
// Include the database configuration file

// Create a new instance of the database class
$db = new Config\Database();

// If a connection was successfully made, the success message will be displayed
// Otherwise, the error message will be echoed from the catch block in Database.php
