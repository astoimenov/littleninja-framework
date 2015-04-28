<?php

use Carbon\Carbon;

foreach ($data as $post) {
    $time = Carbon::createFromTimestamp(strtotime($post['created_at']));
    echo "<h3>{$post['title']}</h3><time>{$time->diffForHumans()}</time>";
}
