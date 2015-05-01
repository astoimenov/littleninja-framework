<?php namespace LittleNinja\Controllers;

use Carbon\Carbon;
use LittleNinja\Lib\Redirect;
use LittleNinja\Lib\View;
use LittleNinja\Models\Post;
use Stringy\Stringy;

class PostsController extends BaseController
{
    public $errors = array();

    public function __construct()
    {
        parent::__construct(get_class(), 'Post', 'blog_posts');
    }

    public function index($order)
    {
        $this->isAdmin();
        $posts = Post::get();

        View::render('posts/index', $posts);
    }

    public function create()
    {
        $this->isAdmin();

        View::render('posts/create');
    }

    public function store()
    {
        $this->isAdmin();

        if (strlen($_POST['title']) < 3) {
            $this->errors['title'] = MESSAGE_TITLE_BAD_LENGTH;
        }
        if (strlen($_POST['content']) < 3) {
            $this->errors['content'] = MESSAGE_CONTENT_BAD_LENGTH;
        }

        if (empty($this->errors)) {
            $post['title'] = htmlspecialchars($_POST['title'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $post['slug'] = Stringy::create($post['title'])->slugify('-');
            $post['content'] = htmlspecialchars($_POST['content'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $post['users_id'] = $this->loggedUser['id'];
            $post['created_at'] = Carbon::now()->timezone('Europe/Sofia');
            Post::store($post);

            Redirect::to('/posts/index');
        }

        View::render('posts/create');
    }

    public function show($slug)
    {
        $postModel = new Post();
        $post = $postModel->getBySlug($slug)[0];

        View::render('posts/show', $post);
    }

    public function edit($slug)
    {
        $this->isAdmin();

        $postModel = new Post();
        $post = $postModel->getBySlug($slug)[0];

        View::render('posts/edit', $post);
    }

    public function update($id)
    {
        $this->isAdmin();

        $post['id'] = $id;
        $post['title'] = htmlspecialchars($_POST['title'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $post['content'] = htmlspecialchars($_POST['content'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $postModel = new Post();
        $postModel->update($post);

        Redirect::to('/posts/index');
    }

    public function delete($id)
    {
        $this->isAdmin();
        $postModel = new Post();
        $postModel->destroy($id);

        Redirect::to('/posts/index');
    }
}
