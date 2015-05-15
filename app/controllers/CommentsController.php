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
            if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $this->errors['email'] = MESSAGE_EMAIL_INVALID;
            }
        }

        if (empty($this->errors) && $this->checkCsrfToken()) {
            if (empty($this->loggedUser)) {
                $comment['visitor_name'] = self::sanitize($_POST['name']);
                $comment['visitor_email'] = self::sanitize($_POST['email']);
            } else {
                $comment['user_id'] = $this->loggedUser['id'];
            }

            $comment['content'] = nl2br(self::sanitize($_POST['content']));
            $comment['blog_post_id'] = $_POST['blog_post_id'];

            $commentModel = new Comment();
            $commentModel->store($comment);

            Redirect::to('/posts/show/' . $_POST['slug']);
        }

        PostsController::show($_POST['slug']);
    }
}
