<article id="sidebar" class="col-sm-3 col-sm-offset-1">
    <h3 class="text-info">Most Used Tags</h3>
    <ul class="tags">
        <?php foreach ($this->tags as $tag) : ?>
        <li><a href="/tags/show/<?= $tag['id'] ?>"><?= $tag['name'] ?></a><?= ' (' . $tag['count'] . ')' ?></li>
        <?php endforeach; ?>
    </ul>
</article>
