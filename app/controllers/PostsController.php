<?php namespace LittleNinja\Controllers;

use Carbon\Carbon;
use LittleNinja\Lib\Redirect;
use LittleNinja\Lib\View;
use LittleNinja\Models\BaseModel;
use LittleNinja\Models\BlogPostsTags;
use LittleNinja\Models\Comment;
use LittleNinja\Models\Post;
use LittleNinja\Models\Tag;
use Stringy\Stringy;

class PostsController extends BaseController
{
    public $errors = array();

    public function __construct()
    {
        parent::__construct(get_class(), 'Post', 'blog_posts');
    }

    public function index()
    {
        $this->isAdmin();
        $this->title = 'Posts | ' . LN_SITE_NAME;

        $postModel = new Post();
        $posts = $postModel->get();

        View::render('posts/index', $posts);
    }

    public function create()
    {
        $this->isAdmin();
        $this->title = 'Create post | ' . LN_SITE_NAME;

        $tagModel = new Tag();
        $tags = $tagModel->get();

        View::render('posts/create', $tags);
    }

    public function store()
    {
        $this->isAdmin();

        if (strlen($_POST['title']) < 3 || mb_strlen($_POST['title']) > 45) {
            $this->errors['title'] = MESSAGE_TITLE_BAD_LENGTH;
        }
        if (strlen($_POST['content']) < 3) {
            $this->errors['content'] = MESSAGE_CONTENT_BAD_LENGTH;
        }

        if (empty($this->errors) && $this->checkCsrfToken()) {
            $post['title'] = self::sanitize($_POST['title']);
            $post['slug'] = Stringy::create($post['title'])->slugify('-');
            $post['content'] = nl2br(self::sanitize($_POST['content']));
            $post['user_id'] = $this->loggedUser['id'];
            $post['created_at'] = Carbon::now();

            $tags = $_POST['tags'];
            $postTagModel = new BlogPostsTags();
            $postTagModel->storePostTags($post, $tags);

            Redirect::to('/home/index');
        }

        View::render('posts/create');
    }

    public function show($slug)
    {
        $postModel = new Post();
        $post = $postModel->getBySlug($slug)[0];
        $this->title = $post['title'] . ' | ' . LN_SITE_NAME;

        $postTagModel = new BlogPostsTags();
        $tags = $postTagModel->getTags($post['id']);
        $post['tags'] = $tags;

        $commentModel = new Comment();
        $post['comments'] = $commentModel->getByPostId($post['id']);

        View::render('posts/show', $post);
    }

    public function edit($slug)
    {
        $this->isAdmin();
        $this->title = 'Edit post | ' . LN_SITE_NAME;

        $postModel = new Post();
        $post = $postModel->getBySlug($slug)[0];

        $postTagModel = new BlogPostsTags();
        $tags = $postTagModel->getTags($post['id']);
        $post['tags'] = $tags;

        View::render('posts/edit', $post);
    }

    public function update($id)
    {
        $this->isAdmin();

        if ($this->checkCsrfToken()) {
            $post['id'] = $id;
            $post['title'] = self::sanitize($_POST['title']);
            $post['content'] = self::sanitize($_POST['content']);

            $postModel = new Post();
            $postModel->update($post);

            Redirect::to('/posts/index');
        }

        Redirect::home();
    }

    public function delete($id)
    {
        $this->isAdmin();

        $postModel = new Post();
        $postModel->destroy($id);

        Redirect::to('/posts/index');
    }
}
