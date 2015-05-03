<?php namespace LittleNinja\Controllers;

use LittleNinja\Lib\Auth;
use LittleNinja\Lib\Redirect;

class BaseController
{
    protected $validationErrors;
    protected $formValues;
    public $title = "LittleNinja's Blog";

    public function __construct(
        $className = 'LittleNinja\Controllers\BaseController',
        $model = 'BaseModel',
        $table = 'none'
    )
    {
        $this->className = $className;
        $modelClass = '\LittleNinja\Models\\' . $model;
        $this->model = new $modelClass(array('table' => $table));

        $auth = Auth::getInstance();
        $this->loggedUser = $auth->getLoggedUser();

        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
        }
    }

    public function isAdmin()
    {
        if ($this->loggedUser['role'] !== 'admin') {
            $this->addErrorMessage('You are not authorized');
            Redirect::to('/home/index');
        }
    }

    public function addErrorMessage($msg)
    {
        $this->addMessage($msg, 'error');
    }

    public function addMessage($msg, $type)
    {
        if (!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = array();
        }

        array_push($_SESSION['messages'], array('text' => $msg, 'type' => $type));
    }

    public function checkCsrfToken()
    {
        if ($_SESSION['csrf_token'] !== $_POST['_token']) {
            return false;
        }

        return true;
    }

    public function authorize()
    {
        if (empty($this->loggedUser)) {
            $this->addErrorMessage('Please login first');
            Redirect::to('/auth/login');
        }
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
}
