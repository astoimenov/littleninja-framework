<?php namespace LittleNinja\Controllers;

use LittleNinja\Lib\Auth;
use LittleNinja\Lib\Redirect;
use LittleNinja\Lib\View;

/**
 * @property string templateName
 */
class BaseController
{
    protected $layout;
    protected $validationErrors;
    protected $formValues;
    protected $isLoggedIn;

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

    public function isAdmin()
    {
        if ($this->loggedUser['role'] !== 'admin') {
            $this->addErrorMessage('You are not authorized');
            Redirect::to('/home/index');
        }
    }

    public function authorize()
    {
        if (empty($this->loggedUser)) {
            $this->addErrorMessage('Please login first');
            Redirect::to('/auth/login');
        }
    }

    public function addMessage($msg, $type)
    {
        if (!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = array();
        }

        array_push($_SESSION['messages'], array('text' => $msg, 'type' => $type));
    }

    public function addValidationError($field, $message)
    {
        $this->validationErrors[$field] = $message;
    }

    public function getValidationError($field)
    {
        return $this->validationErrors[$field];
    }

    public function addFieldValue($field, $value)
    {
        $this->formValues[$field] = $value;
    }

    public function getFieldValue($field)
    {
        return $this->formValues[$field];
    }

    public function addInfoMessage($msg)
    {
        $this->addMessage($msg, 'info');
    }

    public function addErrorMessage($msg)
    {
        $this->addMessage($msg, 'error');
    }
}
