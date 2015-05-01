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
        if (!empty($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
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
        if (!empty($_POST['submit'])) {
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
