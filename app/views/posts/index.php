<div class="panel panel-default">
    <div class="panel-heading">Posts</div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Slug</th>
            <th>Content</th>
            <th>Created at</th>
            <th>Manage</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $post) : ?>
            <tr>
                <td><?= $post['id'] ?></td>
                <td><?= $post['title'] ?></td>
                <td><?= $post['slug'] ?></td>
                <td><?= $this->limit($post['content']) ?></td>
                <td><?= $post['created_at'] ?></td>
                <td>
                    <a href="/posts/edit/<?= $post['slug'] ?>" class="btn btn-default glyphicon glyphicon-edit"></a>
                    <a href="/posts/delete/<?= $post['id'] ?>" class="btn btn-danger glyphicon glyphicon-remove"></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
