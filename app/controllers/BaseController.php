<?php namespace LittleNinja\Controllers;

use LittleNinja\Lib\Auth;

/**
 * @property string templateName
 */
class BaseController
{
    protected $layout;
    protected $viewsDir;

    public function __construct(
        $className = 'LittleNinja\Controllers\BaseController',
        $model = 'BaseModel',
        $viewsDir = '/app/views/master/'
    )
    {
        $this->viewsDir = $viewsDir;
        $this->className = $className;

        include_once LN_ROOT_DIR . '/app/models/' . $model . '.php';
        $modelClass = '\LittleNinja\Models\\' . $model;

        $this->model = new $modelClass(array('table' => 'none'));

        $auth = Auth::getInstance();
        $loggedUser = $auth->getLoggedUser();
        $this->loggedUser = $loggedUser;

        $this->layout = LN_ROOT_DIR . '/app/views/layouts/default.php';
    }

    public function index()
    {
        $this->templateName = LN_ROOT_DIR . $this->viewsDir . 'index.php';
        include_once $this->layout;
    }
}
