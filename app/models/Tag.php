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
}
