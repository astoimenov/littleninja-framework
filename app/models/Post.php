<?php

namespace LittleNinja\Models;

class Post extends BaseModel
{
    public $disabledNext;

    public function __construct($args = array())
    {
        parent::__construct(array('table' => 'blog_posts'));
    }

    public function getFiltered($page)
    {
        $pageSize = LN_DEFAULT_PAGE_SIZE;
        if ($page > 1) {
            $from = ($page * $pageSize) - $pageSize;
        } else {
            $page = 1;
            $from = $page - 1;
        }

        $query = "SELECT * FROM blog_posts"
        . " ORDER BY created_at DESC LIMIT {$from}, {$pageSize}";

        if ($resultSet = $this->db->query($query)) {
            if ($resultSet->num_rows < LN_DEFAULT_PAGE_SIZE) {
                $this->disabledNext = true;
            }

            $results = self::processResults($resultSet);

            return $results;
        } else {
            $this->reportDbError();

            return false;
        }
    }

    public function getById($id)
    {
        $query = "SELECT id, title, content, slug, created_at FROM blog_posts WHERE id = '{$id}'";

        if ($resultSet = $this->db->query($query)) {
            $results = self::processResults($resultSet)[0];

            return $results;
        } else {
            self::reportDbError();

            return false;
        }
    }

    public function getByTitle($title)
    {
        $query = "SELECT id, title, content FROM blog_posts WHERE title = '{$title}'";

        if ($resultSet = $this->db->query($query)) {
            $results = self::processResults($resultSet);

            return $results;
        } else {
            self::reportDbError();

            return false;
        }
    }

    public function getBySlug($slug)
    {
        $query = "SELECT id, title, content, slug FROM blog_posts WHERE slug = '{$slug}'";

        if ($resultSet = $this->db->query($query)) {
            $results = self::processResults($resultSet);

            return $results;
        } else {
            self::reportDbError();

            return false;
        }
    }
}
