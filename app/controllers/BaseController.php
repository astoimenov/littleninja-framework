<?php namespace LittleNinja\Controllers;

use LittleNinja\Lib\Auth;
use LittleNinja\Lib\View;

/**
 * @property string templateName
 */
class BaseController
{
    protected $layout;

    public function __construct(
        $className = 'LittleNinja\Controllers\BaseController',
        $model = 'BaseModel',
        $table = 'none'
    )
    {
        $this->className = $className;

        include_once LN_ROOT_DIR . '/app/models/' . $model . '.php';
        $modelClass = '\LittleNinja\Models\\' . $model;

        $this->model = new $modelClass(array('table' => $table));

        $auth = Auth::getInstance();
        $loggedUser = $auth->getLoggedUser();
        $this->loggedUser = $loggedUser;

        $this->layout = LN_ROOT_DIR . '/app/views/layouts/default.php';
    }

    public function index()
    {
        $view = new View();
        $view->render('master/home');
    }
}
