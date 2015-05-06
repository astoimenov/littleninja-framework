<?php namespace LittleNinja\Controllers;

use LittleNinja\Lib\View;
use LittleNinja\Models\Post;

class HomeController extends BaseController
{
    public $prev = 1;
    public $next = 2;
    public $disabledNext = false;

    public function __construct()
    {
        parent::__construct(get_class(), 'Post');
    }

    public function index($page = null, $pageSize = null)
    {
        $this->title = 'Home | ' . LN_SITE_NAME;
        if ($page <= 1) {
            $this->disabledPrev = true;
            $this->prev = 1;
            $this->next = 2;
        } else {
            $this->prev = $page - 1;
            $this->next = $page + 1;
        }

        $postModel = new Post();

        $posts = $postModel->getFiltered($page, $pageSize);
        $this->disabledNext = $postModel->disabledNext;
        if ($this->disabledNext) {
            $this->next = $page;
        }

        View::renderWithSidebar('home/index', $posts);
    }
}
