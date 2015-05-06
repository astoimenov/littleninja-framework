<h2>Tag: <?= ucfirst($data['tag']) ?></h2>

<section class="articles col-sm-8">
    <?php foreach ($data as $key => $post) {
        if ($key !== 'tag') {
            date_default_timezone_set('Europe/Sofia');
            $time = Carbon\Carbon::createFromTimestamp(strtotime($post['created_at']));
            $content = $this->limit(
                $post['content'],
                200,
                "... <a href='/posts/show/{$post['slug']}'>[Read more]</a>"
            );
            echo "\n<article class='row' id='post-{$post['id']}'>
        <div class='row'>
            <h3 class='col-sm-10'><a href='/posts/show/{$post['slug']}'>{$post['title']}</a></h3>

        </div>
        <time class='text-info' title='{$time}' datetime='{$time}'>{$time->diffForHumans()}</time>
        <div class='post-content'>{$content}</div>
    </article>";
        }
    }
    ?>
</section>
