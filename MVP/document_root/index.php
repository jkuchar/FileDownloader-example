<?php

// absolute filesystem path to the web root
define('WWW_DIR', __DIR__);

// absolute filesystem path to the application root
define('APP_DIR', WWW_DIR . '/../app');

define('TEMP_DIR', APP_DIR . '/cache');

// absolute filesystem path to the libraries
define('LIBS_DIR', WWW_DIR . '/../../../libs');

// load bootstrap file
require APP_DIR . '/bootstrap.php';
