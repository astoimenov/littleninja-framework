<?php

use LittleNinja\Lib\Database;

define('LN_DS', DIRECTORY_SEPARATOR);
define('LN_ROOT_DIR', dirname(dirname(__FILE__ . '/')));
define('LN_ROOT_PATH', dirname(basename(dirname(__FILE__)) . '/'));
define('LN_DEFAULT_CONTROLLER', 'base');
define('LN_DEFAULT_ACTION', 'index');

$request = '.' . $_SERVER['REQUEST_URI'];
$request_home = LN_ROOT_PATH . '/';

$controller = LN_DEFAULT_CONTROLLER;
$action = LN_DEFAULT_ACTION;
$param = array();
$admin_routing = false;

$loader = require __DIR__ . '/../vendor/autoload.php';
include_once '../config/db.php';
include_once '../lib/database.php';
include_once '../lib/auth.php';

if (!empty($request)) {
    if (strpos($request, $request_home) === 0) {
        $request = substr($request, strlen($request_home));

        if (strpos($request, 'admin/') === 0) {
            $admin_routing = true;
            $request = substr($request, strlen('admin/'));
        }

        $components = explode('/', $request, 3);

        if (count($components) > 1) {
            list($controller, $action) = $components;

            if (isset($components[2])) {
                $param = $components[2];
            }
        }
    }
}

var_dump($controller);
var_dump($action);
var_dump($param);

$admin_folder = $admin_routing ? 'Admin\\' : '';
$controller_class = 'LittleNinja\Controllers\\' . $admin_folder . ucfirst($controller) . 'Controller';

$instance = new $controller_class();

if (method_exists($instance, $action)) {
    call_user_func_array(array($instance, $action), array($param));
}

$db_object = Database::getInstance();
$db = $db_object::getDb();
