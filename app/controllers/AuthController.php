<?php namespace LittleNinja\Controllers;

use LittleNinja\Lib\Auth;

/**
 * @property string templateName
 * @property bool isLoggedIn
 */
class AuthController extends BaseController
{
    public $registrationSuccessful = false;

    public $verificationSuccessful = false;

    public function __construct()
    {
        parent::__construct(get_class(), 'BaseModel', '/app/views/auth/');
    }

    public function register()
    {
        if (!empty($_POST['email']) || !empty($_POST['pass'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['pass'];
            $pass_repeat = $_POST['password_confirmation'];

            $auth = Auth::getInstance();
            $auth->register($name, $email, $password, $pass_repeat);
        }

        $this->templateName = LN_ROOT_DIR . $this->viewsDir . 'register.php';
        include_once $this->layout;
    }

    public function login()
    {
        if (!(empty($_POST['email']) || empty($_POST['pass']))) {
            $email = $_POST['email'];
            $password = $_POST['pass'];

            $auth = Auth::getInstance();
            $this->isLoggedIn = $auth->login($email, $password);

            header('Location: /');
        }

        $this->templateName = LN_ROOT_DIR . $this->viewsDir . 'login.php';
        include_once $this->layout;
    }

    public function logout()
    {
        $auth = Auth::getInstance();
        $auth->logout();
    }
}
