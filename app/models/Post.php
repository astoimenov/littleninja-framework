<?php

namespace LittleNinja\Models;

class Post extends BaseModel
{
    public function __construct($args = array())
    {
        parent::__construct(array('table' => 'blog_posts'));
    }

    public function getByTitle($title)
    {
        return self::get(array(
            'where' => "title = '" . $title . "'"
        ));
    }

    public function getBySlug($slug)
    {
        $query = "SELECT id,title,content,users_id FROM blog_posts WHERE slug = '{$slug}'";

        if ($resultSet = $this->db->query($query)) {
            $results = self::processResults($resultSet);

            return $results;
        } else {
            var_dump($this->db->error);
            die;
        }
    }
}
