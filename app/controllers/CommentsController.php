<?php namespace LittleNinja\Controllers;

use LittleNinja\Lib\Redirect;
use LittleNinja\Lib\View;
use LittleNinja\Models\Comment;
use LittleNinja\Models\Post;

class CommentsController extends BaseController
{
    public $errors = array();

    public function __construct()
    {
        parent::__construct(get_class(), 'Comment', 'comments');
    }

    public function store()
    {
        if (strlen($_POST['content']) < 3) {
            $this->errors['content'] = MESSAGE_CONTENT_BAD_LENGTH;
        }

        if (empty($this->loggedUser)) {
            if (strlen($_POST['name']) < 3) {
                $this->errors['name'] = MESSAGE_NAME_BAD_LENGTH;
            }
            if (strlen($_POST['email']) < 3) {
                $this->errors['email'] = MESSAGE_EMAIL_EMPTY;
            }
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $this->errors['email'] = MESSAGE_EMAIL_INVALID;
            }
        }

        if (empty($this->errors) && $this->checkCsrfToken()) {
            if (empty($this->loggedUser)) {
                $comment['visitor_name'] = htmlspecialchars($_POST['name'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $comment['visitor_email'] = htmlspecialchars($_POST['email'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            } else {
                $comment['users_id'] = $this->loggedUser['id'];
            }

            $comment['content'] = htmlspecialchars($_POST['content'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $comment['blog_posts_id'] = $_POST['blog_post_id'];

            $commentModel = new Comment();
            $commentModel->store($comment);

            Redirect::to('/posts/show/' . $_POST['slug']);
        }

        PostsController::show($_POST['slug']);
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
