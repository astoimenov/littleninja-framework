<?php

namespace LittleNinja\Controllers;

use LittleNinja\Lib\View;
use LittleNinja\Models\Post;

class PostsController extends BaseController
{
    public function __construct()
    {
        parent::__construct(get_class(), 'Post', 'blog_posts');
    }

    public function index($order)
    {
        $data = Post::get(array('order_by' => 'created_at', 'order' => 'DESC'));
        View::render('posts/index', $data);
    }

    public function create()
    {
        View::render('posts/create');
    }

    public function store()
    {
        $post = new Post();
    }

    public function edit()
    {
        View::render('posts/edit');
    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
