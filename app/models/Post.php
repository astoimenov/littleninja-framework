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
}
