<?php namespace LittleNinja\Controllers;

use LittleNinja\Lib\Auth;
use LittleNinja\Lib\Redirect;
use LittleNinja\Lib\View;

class AuthController extends BaseController
{
    public function __construct()
    {
        parent::__construct(get_class(), 'BaseModel');
    }

    public function register()
    {
        if (!empty($_POST['submit']) && $this->checkCsrfToken()) {
            $name = self::sanitize($_POST['name']);
            $email = self::sanitize($_POST['email']);
            $password = $_POST['password'];
            $passRepeat = $_POST['password_confirmation'];

            $auth = Auth::getInstance();
            if ($auth->register($name, $email, $password, $passRepeat)) {
                Redirect::to('/auth/login');
            }
        }

        View::render('auth/register');
    }

    public function login()
    {
        if (!empty($_POST['submit']) && $this->checkCsrfToken()) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $auth = Auth::getInstance();

            if ($auth->login($email, $password)) {
                Redirect::home();
            }
        }

        View::render('auth/login');
    }

    public function logout()
    {
        $auth = Auth::getInstance();
        $auth->logout();
    }
}
