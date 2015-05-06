<?php namespace LittleNinja\Controllers;

use LittleNinja\Lib\View;
use LittleNinja\Models\BlogPostsTags;
use LittleNinja\Models\Tag;

class TagsController extends BaseController
{
    public function __construct()
    {
        parent::__construct(get_class(), 'Comment', 'comments');
    }

    public function show($id)
    {
        $postTagModel = new BlogPostsTags();
        $posts = $postTagModel->getPosts($id);
        $tagModel = new Tag();
        $posts['tag'] = $tagModel->getById($id)[0]['name'];

        View::renderWithSidebar('tags/show', $posts);
    }
}
