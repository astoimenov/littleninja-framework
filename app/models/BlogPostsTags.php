<?php namespace LittleNinja\Models;

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

    public function storePostTags($post, $tags)
    {
        $tagIds = array();
        if (!empty($tags)) {
            $tagModel = new Tag();
            foreach ($tags as $tag) {
                if ($oldTag = $tagModel->getByName($tag)) {
                    $tagIds[] = (int)$oldTag[0]['id'];
                } else {
                    $newTag['name'] = htmlspecialchars($tag, ENT_QUOTES | ENT_HTML5, 'UTF-8');
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
