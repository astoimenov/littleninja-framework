<?php namespace LittleNinja\Models;

use LittleNinja\Controllers\BaseController;

class User extends BaseModel
{
    public $errors;

    public function __construct($args = array())
    {
        parent::__construct(array('table' => 'users'));
    }

    public function getById($id)
    {
        $query = "SELECT id, name, email, role FROM users WHERE id = '{$id}'";

        if ($resultSet = $this->db->query($query)) {
            $results = self::processResults($resultSet)[0];

            return $results;
        } else {
            var_dump($this->db->error);
            die;
        }
    }

    public function getByName($name)
    {
        return $this->get(array(
            'where' => "name = '" . $name . "'"
        ));
    }

    public function update($element)
    {
        BaseController::validateUserInput($element['name'], $element['email']);

        if ($queryCheckUser = $this->db->prepare("SELECT email FROM users WHERE email=?")) {
            $queryCheckUser->bind_param('s', $element['email']);
            $queryCheckUser->execute();
            $result = $queryCheckUser->fetch();
            if (count($result) > 0) {
                $this->errors['email'] = MESSAGE_EMAIL_ALREADY_EXISTS;

                return false;
            } else {
                self::update($element);
            }
        }
    }
}
