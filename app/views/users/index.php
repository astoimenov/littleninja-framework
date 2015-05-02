<div class="panel panel-default">
    <div class="panel-heading">Users</div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Manage</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $user) : ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['role'] ?></td>
                <td>
                    <a href="/users/edit/<?= $user['id'] ?>" class="btn btn-default glyphicon glyphicon-edit"></a>
                    <a href="/users/delete/<?= $user['id'] ?>" class="btn btn-danger glyphicon glyphicon-remove"></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
