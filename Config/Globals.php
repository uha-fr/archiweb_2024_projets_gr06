<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('CLASSDIR', ROOT . DS . 'app');
define('CONTROLLERSDIR', CLASSDIR . DS . 'Controller');
define('MODELSDIR', CLASSDIR . DS . 'Model');
define('VIEWSDIR', CLASSDIR . DS . 'Views');
define('TEMPLATESDIR', VIEWSDIR . DS . 'templates');

define('BASE_APP_DIR', '/archiweb_2024_projets_gr06');
define('APPJSON', 'Content-Type: application/json');

define('USER_ID', ':user_id');
define('EMAIL', ':email');
