<?php namespace LittleNinja\Controllers;

use LittleNinja\Lib\Redirect;
use LittleNinja\Lib\View;
use LittleNinja\Models\User;

class UsersController extends BaseController
{
    public $errors = array();
    private $userModel;

    public function __construct()
    {
        parent::__construct(get_class(), 'User', 'users');
        $this->userModel = new User();
    }

    public function index()
    {
        $this->isAdmin();

        $users = $this->userModel->get(array(
            'columns' => 'id, name, email, role'
        ));

        View::render('users/index', $users);
    }

    public function edit($id)
    {
        if ($this->loggedUser['role'] === 'admin' || $this->loggedUser['id'] == $id) {
            $user = $this->userModel->getById($id);

            View::render('users/edit', $user);
        } else {
            Redirect::home();
        }
    }

    public function update($id)
    {
        if ($this->loggedUser['role'] === 'admin' || $this->loggedUser['id'] == $id) {
            if ($this->checkCsrfToken()) {
                $user['id'] = $id;
                $user['name'] = htmlspecialchars($_POST['name'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $user['email'] = htmlspecialchars($_POST['email'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $user['role'] = $_POST['role'];

                $this->userModel->update($user);

                Redirect::to('/users/index');
            }
        }

        Redirect::home();
    }

    public function delete($id)
    {
        $this->isAdmin();

        $this->userModel->destroy($id);

        Redirect::to('/users/index');
    }
}
