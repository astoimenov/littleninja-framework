<?php

define('LN_DS', DIRECTORY_SEPARATOR);
define('LN_URL', 'http://' . $_SERVER['HTTP_HOST']);
define('LN_ROOT_DIR', dirname(dirname(__FILE__ . '/')));
define('LN_ROOT_PATH', dirname(basename(dirname(__FILE__)) . '/'));
define('LN_PATH_VIEW', LN_ROOT_DIR . '/app/views/');
define('LN_DEFAULT_CONTROLLER', 'home');
define('LN_DEFAULT_ACTION', 'index');
