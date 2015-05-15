<?php namespace LittleNinja\Controllers;

use LittleNinja\Lib\Auth;
use LittleNinja\Lib\Redirect;
use LittleNinja\Models\Tag;

class BaseController
{
    public $title = LN_SITE_NAME;
    public $tags = array();
    public $errors = array();
    public $disabledPrev = false;
    public $disabledNext = false;

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

        $tagModel = new Tag();
        $this->tags = $tagModel->getMostUsedTags();
    }

    public function isAdmin()
    {
        if ($this->loggedUser['role'] !== 'admin') {
            Redirect::to('/home/index');
        }
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
            Redirect::to('/auth/login');
        }
    }

    public function validateUserInput($name, $email)
    {
        $name = trim($name);
        $email = trim($email);

        if (empty($name)) {
            $this->errors['name'] = MESSAGE_NAME_EMPTY;
        }
        if (strlen($name) < 2 || strlen($name) > 255) {
            $this->errors['name'] = MESSAGE_NAME_BAD_LENGTH;
        }

        if (empty($email) || $email === null) {
            $this->errors['email'] = MESSAGE_EMAIL_EMPTY;
            $email = null;
        }
        if (strlen($email) > 255) {
            $this->errors['email'] = MESSAGE_EMAIL_TOO_LONG;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = MESSAGE_EMAIL_INVALID;
        }

        return array($name, $email);
    }

    public static function sanitize($value)
    {
        $value = trim($value);
        $sanitized = htmlspecialchars(trim($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return $sanitized;
    }

    public static function limit($value, $limit = 100, $end = '...')
    {
        if (mb_strlen($value) <= $limit) {
            return $value;
        }

        return rtrim(mb_substr($value, 0, $limit, 'UTF-8')) . $end;
    }
}
