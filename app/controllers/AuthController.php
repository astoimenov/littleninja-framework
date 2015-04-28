<?php namespace LittleNinja\Controllers;

use LittleNinja\Lib\Auth;
use LittleNinja\Lib\Redirect;
use LittleNinja\Lib\View;

/**
 * @property bool isLoggedIn
 */
class AuthController extends BaseController
{
    public $registrationSuccessful = false;
    public $verificationSuccessful = false;

    public function __construct()
    {
        parent::__construct(get_class(), 'BaseModel');
    }

    public function register()
    {
        if (!empty($_POST['email']) || !empty($_POST['pass'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['pass'];
            $passRepeat = $_POST['password_confirmation'];

            $auth = Auth::getInstance();
            $auth->register($name, $email, $password, $passRepeat);
        }

        View::render('auth/register');
    }

    public function login()
    {
        if (!(empty($_POST['email']) || empty($_POST['pass']))) {
            $email = $_POST['email'];
            $password = $_POST['pass'];

            $auth = Auth::getInstance();

            $this->isLoggedIn = $auth->login($email, $password);
            Redirect::home();
        }

        View::render('auth/login');
    }

    public function logout()
    {
        $auth = Auth::getInstance();
        $auth->logout();
    }
}
