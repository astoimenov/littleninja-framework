<?php namespace LittleNinja\Controllers;

use LittleNinja\Lib\View;
use LittleNinja\Models\Post;

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct(get_class(), 'Post');
    }

    public function index()
    {
        $args = array('order_by' => 'created_at', 'order' => 'DESC');
        $posts = Post::get($args);

        View::render('home/index', $posts);
    }
}
