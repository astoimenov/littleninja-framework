<?php namespace LittleNinja\Models;

class Tag extends BaseModel
{
    public function __construct($args = array())
    {
        parent::__construct(array('table' => 'tags'));
    }

    public function getByName($name)
    {
        return $this->get(array(
            'where' => "name = '" . $name . "'"
        ));
    }

    public function getMostUsedTags()
    {
        $query = "SELECT t.id, t.name, count(*) as count FROM blog_posts_tags "
            . " LEFT JOIN tags t ON tag_id=t.id GROUP BY tag_id "
            . " ORDER BY count(tag_id) DESC"
            . ", t.name";

        $resultSet = $this->db->query($query);
        $tags = self::processResults($resultSet);

        return $tags;
    }
}
