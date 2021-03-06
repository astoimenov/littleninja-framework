<?php namespace LittleNinja\Models;

use LittleNinja\Controllers\BaseController;

class BlogPostsTags extends BaseModel
{
    public function __construct($args = array())
    {
        parent::__construct(array('table' => 'blog_posts_tags'));
    }

    public function getTagIds($postId)
    {
        return $this->get(array(
            'where' => "blog_post_id = '" . $postId . "'",
            'columns' => 'tag_id'
        ));
    }

    public function getPostIds($tagId)
    {
        return $this->get(array(
            'where' => "tag_id = '" . $tagId . "'",
            'columns' => 'blog_post_id'
        ));
    }

    public function getTags($postId)
    {
        $tagIds = self::getTagIds($postId);
        $tagModel = new Tag();
        $tags = array();
        foreach ($tagIds as $key => $tagId) {
            $tags[] = $tagModel->getById((int)$tagId['tag_id'])[0];
        }

        return $tags;
    }

    public function getPosts($tagId)
    {
        $postIds = self::getPostIds($tagId);
        $postModel = new Post();
        $posts = array();
        foreach ($postIds as $key => $postId) {
            $posts[] = $postModel->getById((int)$postId['blog_post_id']);
        }

        return $posts;
    }

    public function storePostTags($post, $tags)
    {
        $tagIds = array();
        if (!empty($tags)) {
            $tagModel = new Tag();
            foreach ($tags as $tag) {
                if ($oldTag = $tagModel->getByName($tag)) {
                    $tagIds[] = (int)$oldTag[0]['id'];
                } else {
                    $newTag['name'] = BaseController::sanitize($tag);
                    $tagIds[] = $tagModel->store($newTag);
                }
            }
        }

        $postModel = new Post();
        $postId = $postModel->store($post);
        foreach ($tagIds as $tagId) {
            $postTag['blog_post_id'] = $postId;
            $postTag['tag_id'] = $tagId;
            $postTagModel = new BlogPostsTags();
            $postTagModel->store($postTag);
        }
    }
}
