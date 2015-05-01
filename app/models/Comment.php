<?php namespace LittleNinja\Models;

class Comment extends BaseModel
{
    public function __construct($args = array())
    {
        parent::__construct(array('table' => 'comments'));
    }

    public function getByPostId($id)
    {
        $query = "SELECT comments.id,content,visitor_name,users.name FROM comments "
        . "LEFT JOIN users ON users_id=users.id WHERE blog_posts_id = '{$id}' ";


        if ($resultSet = $this->model->db->query($query)) {
            $results = self::processResults($resultSet);

            return $results;
        } else {
            var_dump($this->model->db->error);
            die;
        }
    }
}
