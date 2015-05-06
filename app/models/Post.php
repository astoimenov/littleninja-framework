<?php

namespace LittleNinja\Models;

class Post extends BaseModel
{
    public function __construct($args = array())
    {
        parent::__construct(array('table' => 'blog_posts'));
    }

    public function getById($id)
    {
        $query = "SELECT id, title, content, slug, created_at FROM blog_posts WHERE id = '{$id}'";

        if ($resultSet = $this->db->query($query)) {
            $results = self::processResults($resultSet)[0];

            return $results;
        } else {
            var_dump($this->db->error);
            die;
        }
    }

    public function getByTitle($title)
    {
        $query = "SELECT id, title, content FROM blog_posts WHERE title = '{$title}'";

        if ($resultSet = $this->db->query($query)) {
            $results = self::processResults($resultSet);

            return $results;
        } else {
            var_dump($this->db->error);
            die;
        }
    }

    public function getBySlug($slug)
    {
        $query = "SELECT id, title, content, slug FROM blog_posts WHERE slug = '{$slug}'";

        if ($resultSet = $this->db->query($query)) {
            $results = self::processResults($resultSet);

            return $results;
        } else {
            var_dump($this->db->error);
            die;
        }
    }
}
