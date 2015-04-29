<?php namespace LittleNinja\Controllers;

use Carbon\Carbon;
use LittleNinja\Lib\Redirect;
use LittleNinja\Lib\View;
use LittleNinja\Models\Post;
use Stringy\Stringy;

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
        $post['title'] = $_POST['title'];
        $post['slug'] = Stringy::create($post['title'])->slugify('-');
        $post['content'] = $_POST['content'];
        $post['users_id'] = $this->loggedUser['id'];
        $post['created_at'] = Carbon::now();
        Post::store($post);
        Redirect::to('/posts/index');
    }

    public function show($slug)
    {
        $postModel = new Post();
        $data = $postModel->getBySlug($slug);
        View::render('posts/show', $data[0]);
    }

    public function edit($slug)
    {
        $postModel = new Post();
        $data = $postModel->getBySlug($slug);
        View::render('posts/edit', $data[0]);
    }

    public function update()
    {

    }

    public function delete($id)
    {
        $postModel = new Post();
        $postModel->destroy($id);
        Redirect::to('/posts/index');
    }
}
