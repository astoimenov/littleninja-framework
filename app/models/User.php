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
            self::reportDbError();

            return false;
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

        $query = "SELECT id, email FROM users WHERE email='{$element['email']}'";
        if ($resultSet = $this->db->query($query)) {
            $result = self::processResults($resultSet)[0];
            if (count($result) > 0 && $result['id'] !== $element['id']) {
                $this->errors['email'] = MESSAGE_EMAIL_ALREADY_EXISTS;

                return false;
            } else {
                BaseModel::update($element);

                return true;
            }
        } else {
            self::reportDbError();

            return false;
        }
    }
}
