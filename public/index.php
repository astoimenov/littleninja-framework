<?php

define('LN_DS', DIRECTORY_SEPARATOR);
define('LN_URL', 'http://' . $_SERVER['HTTP_HOST']);
define('LN_ROOT_DIR', dirname(dirname(__FILE__ . '/')));
define('LN_ROOT_PATH', dirname(basename(dirname(__FILE__)) . '/'));
define('LN_PATH_VIEW', LN_ROOT_DIR . '/app/views/');
define('LN_DEFAULT_CONTROLLER', 'base');
define('LN_DEFAULT_ACTION', 'index');

$request = '.' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestHome = LN_ROOT_PATH . '/';

$controller = LN_DEFAULT_CONTROLLER;
$action = LN_DEFAULT_ACTION;
$param = array();
$adminRouting = false;

$loader = require __DIR__ . '/../vendor/autoload.php';
include_once '../config/db.php';
include_once '../config/messages.php';
include_once '../app/lib/Database.php';
include_once '../app/lib/Auth.php';

if (!empty($request)) {
    if (strpos($request, $requestHome) === 0) {
        $request = substr($request, strlen($requestHome));

        if (strpos($request, 'admin/') === 0) {
            $adminRouting = true;
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

$adminFolder = $adminRouting ? 'Admin\\' : '';
$controllerClassName = ucfirst(strtolower($controller)) . 'Controller';
$controllerClass = 'LittleNinja\Controllers\\' . $adminFolder . $controllerClassName;

if (class_exists($controllerClass)) {
    $instance = new $controllerClass();
} else {
    /*$controllerClass = 'LittleNinja\Controllers\\' . ucfirst(LN_DEFAULT_CONTROLLER) . 'Controller';
    $instance = new $controllerClass();*/

    header('Location: /');
    exit;
}

$action = strtolower($action);
if (method_exists($instance, $action)) {
    call_user_func_array(array($instance, $action), array($param));
} else {
    call_user_func_array(array($instance, LN_DEFAULT_ACTION), array($param));
}
