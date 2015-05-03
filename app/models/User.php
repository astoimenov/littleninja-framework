<?php namespace LittleNinja\Models;

class User extends BaseModel
{
    public function __construct($args = array())
    {
        parent::__construct(array('table' => 'users'));
    }

    public function getById($id)
    {
        $query = "SELECT id,name,email FROM users WHERE id = '{$id}'";

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
}
