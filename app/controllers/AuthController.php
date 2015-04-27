<?php namespace LittleNinja\Controllers;

use LittleNinja\Lib\Auth;

class AuthController extends BaseController
{
    public $registrationSuccessful = false;

    public $verificationSuccessful = false;

    public $errors = array();

    public $messages = array();

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

        $template_name = LN_ROOT_DIR . $this->views_dir . 'register.php';

        include_once $this->layout;
    }

    public function login()
    {
        if (!(empty($_POST['email']) || empty($_POST['pass']))) {
            $email = $_POST['email'];
            $password = $_POST['pass'];

            $auth = Auth::getInstance();

            $is_logged_in = $auth->login($email, $password);
        }

        $template_name = LN_ROOT_DIR . $this->views_dir . 'login.php';

        include_once $this->layout;
    }
}
