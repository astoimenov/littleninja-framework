<?php namespace LittleNinja\Models;

use LittleNinja\Lib\Database;

class BaseModel
{
    protected $table;
    protected $limit;
    protected $db;

    public function __construct($args = array())
    {
        $defaults = array(
            'limit' => 0
        );

        $args = array_merge($defaults, $args);
        if (!isset($args['table'])) {
            die('Table not defined.');
        }

        extract($args);
        $this->table = $table;
        $this->limit = $limit;
        $dbObject = Database::getInstance();
        $this->db = $dbObject::getDb();
    }

    public function get($args = array())
    {
        $defaults = array(
            'table' => $this->model->table,
            'limit' => $this->model->limit,
            'where' => '',
            'columns' => '*',
            'order_by' => '',
            'order' => 'ASC'
        );

        $args = array_merge($defaults, $args);
        extract($args);
        $query = "SELECT {$columns} FROM {$table}";

        if (!empty($where)) {
            $query .= " WHERE {$where}";
        }

        if (!empty($order_by)) {
            $query .= " ORDER BY {$order_by} {$order}";
        }

        if (!empty($limit)) {
            $query .= " LIMIT {$limit}";
        }

        $resultSet = $this->model->db->query($query);
        $results = self::processResults($resultSet);

        return $results;
    }

    public function getById($id)
    {
        return self::get(['where' => 'id = ' . $id]);
    }

    public function store($element)
    {
        $keys = array_keys($element);
        $values = array();
        foreach ($element as $key => $value) {
            $values[] = "'" . $this->model->db->real_escape_string($value) . "'";
        }

        $keys = implode($keys, ',');
        $values = implode($values, ',');
        $query = "INSERT INTO {$this->model->table}($keys) VALUES($values)";

        if ($this->model->db->query($query)) {
            return $this->model->db->affected_rows;
        } else {
            var_dump($this->model->db->error);
            die;
        }
    }

    public function update($element)
    {
        if (!isset($element['id'])) {
            die('Wrong model set.');
        }

        $query = "UPDATE {$this->table} SET ";
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
        $query = "DELETE FROM {$this->table} WHERE id = {$id}";
        if ($this->db->query($query)) {
            return $this->db->affected_rows;
        } else {
            var_dump($this->db->error);
            die;
        }
    }

    protected function processResults($resultSet)
    {
        $results = array();

        if (!empty($resultSet) && $resultSet->num_rows > 0) {
            while ($row = $resultSet->fetch_assoc()) {
                $results[] = $row;
            }
        }

        return $results;
    }

    public function getByName($name)
    {
        return $this->get(array(
            'where' => "name = '" . $name . "'"
        ));
    }
}
