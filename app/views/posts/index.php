<section class="articles col-sm-8">
<?php

use Carbon\Carbon;

foreach ($data as $post) {
    $time = Carbon::createFromTimestamp(strtotime($post['created_at']));
    echo "\n<article class='row' id='post-{$post['id']}'>
        <div class='row'>
            <h3 class='col-sm-10'><a href='/posts/show/{$post['slug']}'>{$post['title']}</a></h3>
            <a href='/posts/edit/{$post['slug']}' class='btn btn-default glyphicon glyphicon-edit'></a>
            <a href='/posts/delete/{$post['id']}' class='btn btn-danger glyphicon glyphicon-remove'></a>
        </div>
        <time>{$time->diffForHumans()}</time>
        <div class='post-content'>{$post['content']}</div>
    </article>";
}
?>
</section>
