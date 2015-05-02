<form method="POST" action="/users/update/<?php echo $data['id'] ?>" accept-charset="UTF-8">
    <input name="_token" type="hidden" value="<?= $_SESSION['csrf_token'] ?>">

    <div class="form-group">
        <label for="name">Name:</label>
        <input class="form-control" value="<?php echo $data['name'] ?>" name="name" type="text" id="name">
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input class="form-control" value="<?php echo $data['email'] ?>" name="email" type="text" id="email">
    </div>

    <?php if ($this->loggedUser['role'] === 'admin') : ?>
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control">
                <option value=""></option>
                <option value="admin">admin</option>
                <option value="contentMaker">content maker</option>
            </select>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <input class="btn btn-primary form-control" type="submit" value="Edit user">
    </div>
</form>
