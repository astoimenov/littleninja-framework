<?php namespace LittleNinja\Lib;

class Router
{
    public static function router()
    {
        $request = '.' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestHome = LN_ROOT_PATH . '/';

        $controller = LN_DEFAULT_CONTROLLER;
        $action = LN_DEFAULT_ACTION;
        $params = array();
        $adminRouting = false;

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
                        $params = explode('/', $components[2]);
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
            $controllerClass = 'LittleNinja\Controllers\\' . ucfirst(LN_DEFAULT_CONTROLLER) . 'Controller';
            $instance = new $controllerClass();
        }

        $action = strtolower($action);
        if (method_exists($instance, $action)) {
            call_user_func_array(array($instance, $action), $params);
        } else {
            call_user_func_array(array($instance, LN_DEFAULT_ACTION), $params);
        }
    }
}
