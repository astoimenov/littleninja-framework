<?php namespace LittleNinja\Controllers;

use LittleNinja\Lib\Auth;

abstract class BaseController
{
    protected $layout;
    protected $views_dir;

    public function __construct(
        $class_name = 'LittleNinja\Controllers\BaseController',
        $model = 'BaseModel',
        $views_dir = '/app/views/master/'
    )
    {
        $this->views_dir = $views_dir;
        $this->class_name = $class_name;

        include_once LN_ROOT_DIR . '/app/models/' . $model . '.php';
        $model_class = '\LittleNinja\Models\\' . $model;

        $this->model = new $model_class(array('table' => 'none'));

        $auth = Auth::getInstance();
        $logged_user = $auth->getLoggedUser();
        $this->logged_user = $logged_user;

        $this->layout = LN_ROOT_DIR . '/app/views/layouts/default.php';
    }

    public function index()
    {
        $template_name = LN_ROOT_DIR . $this->views_dir . 'index.php';

        include_once $this->layout;
    }
}
