<section class="articles col-sm-8">
    <?php foreach ($data as $post) {
        date_default_timezone_set('Europe/Sofia');
        $time = Carbon\Carbon::createFromTimestamp(strtotime($post['created_at']));
        echo "\n<article class='row' id='post-{$post['id']}'>
        <div class='row'>
            <h3 class='col-sm-10'><a href='/posts/show/{$post['slug']}'>{$post['title']}</a></h3>

        </div>
        <time class='text-info' title='{$time}' datetime='{$time}'>{$time->diffForHumans()}</time>
        <div class='post-content'>{$post['content']}</div>
    </article>";
    }
    ?>
</section>
