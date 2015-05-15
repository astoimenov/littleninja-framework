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
        $this->title = 'Users | ' . LN_SITE_NAME;

        $users = $this->userModel->get(array(
            'columns' => 'id, name, email, role'
        ));

        View::render('users/index', $users);
    }

    public function edit($id)
    {
        $this->isAdmin();
        $this->title = 'Edit user | ' . LN_SITE_NAME;

        $user = $this->userModel->getById($id);

        View::render('users/edit', $user);
    }

    public function myprofile()
    {
        $this->title = 'My profile | ' . LN_SITE_NAME;

        $id = $this->loggedUser['id'];
        $user = $this->userModel->getById($id);

        View::render('users/edit', $user);
    }

    public function update($id)
    {
        if ($this->loggedUser['role'] === 'admin' || $this->loggedUser['id'] == $id) {
            $user['id'] = $id;
            $user['name'] = self::sanitize($_POST['name']);
            $user['email'] = self::sanitize($_POST['email']);
            if ($this->loggedUser['role'] === 'admin') {
                $user['role'] = $_POST['role'];
            }

            if ($this->checkCsrfToken() && empty($this->errors)) {
                if ($this->userModel->update($user)) {
                    Redirect::home();
                } else {
                    $user['errors'] = $this->userModel->errors;

                    View::render('users/edit', $user);
                }
            } else {
                $user['errors'] = $this->errors;

                View::render('users/edit', $user);
            }
        } else {
            Redirect::home();
        }
    }

    public function delete($id)
    {
        $this->isAdmin();

        $this->userModel->destroy($id);

        Redirect::to('/users/index');
    }
}
