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

    public function update($element)
    {
        if (!isset($element['id'])) {
            die('Wrong model set.');
        }

        $query = "UPDATE users SET ";
        foreach ($element as $key => $value) {
            if ($key === 'id') {
                continue;
            }

            $query .= "$key = '" . $this->db->real_escape_string($value) . "',";
        }

        $query = rtrim($query, ',');
        $query .= " WHERE id = {$element['id']}";
        $this->db->query($query);

        return $this->db->affected_rows;
    }

    public function destroy($id)
    {
        $query = "DELETE FROM users WHERE id = {$id}";
        if ($this->db->query($query)) {
            return $this->db->affected_rows;
        } else {
            var_dump($this->db->error);
            die;
        }
    }
}
