<?php namespace LittleNinja\Models;

use LittleNinja\Lib\Database;
use LittleNinja\Lib\View;

class BaseModel
{
    protected $table;
    protected $limit;
    protected $db;
    public $dbError;

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

    public function getById($id)
    {
        return self::get(['where' => 'id = ' . $id]);
    }

    public function get($args = array())
    {
        $defaults = array(
            'table' => $this->table,
            'limit' => $this->limit,
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

        if ($resultSet = $this->db->query($query)) {
            $results = self::processResults($resultSet);

            return $results;
        } else {
            $this->reportDbError();

            return false;
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

    public function store($element)
    {
        $keys = array_keys($element);
        $values = array();
        foreach ($element as $key => $value) {
            $values[] = "'" . $this->db->real_escape_string(trim($value)) . "'";
        }

        $keys = implode($keys, ',');
        $values = implode($values, ',');
        $query = "INSERT INTO {$this->table}($keys) VALUES($values)";

        if ($this->db->query($query)) {
            return $this->db->insert_id;
        } else {
            $this->reportDbError();

            return false;
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

        if ($this->db->query($query)) {
            return $this->db->affected_rows;
        } else {
            $this->reportDbError();

            return false;
        }
    }

    public function destroy($id)
    {
        $query = "DELETE FROM {$this->table} WHERE id = {$id}";

        if ($this->db->query($query)) {
            return $this->db->affected_rows;
        } else {
            $this->reportDbError();

            return false;
        }
    }

    protected function reportDbError()
    {
        var_dump($this->db->error);
        exit;

        /*error_reporting(E_USER_WARNING);
        error_log(
            '[' . date("F j, Y, g:i a e O") . ']' . $this->db->error . PHP_EOL,
            3,
            LN_ROOT_DIR . '\logs\db-errors.log'
        );

        View::render('errors/db');
        exit;*/
    }
}
