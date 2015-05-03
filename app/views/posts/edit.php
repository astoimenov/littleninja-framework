<form method="POST" action="/posts/update/<?php echo $data['id'] ?>" accept-charset="UTF-8">
    <input name="_token" type="hidden" value="<?= $_SESSION['csrf_token'] ?>">

    <div class="form-group">
        <label for="title">Title:</label>
        <input class="form-control" value="<?php echo $data['title'] ?>" name="title" type="text" id="title">
    </div>

    <div class="form-group">
        <label for="content">Content:</label>
        <textarea class="form-control" name="content"
                  cols="50" rows="10" id="content"><?php echo $data['content'] ?></textarea>
    </div>

    <div class="form-group">
        <label for="tags">Tags:</label>

        <select name="tags[]" id="tags" class="form-control" multiple="multiple">
            <?php foreach ($data['tags'] as $tag) : ?>
                <option value="<?= $tag['name'] ?>" selected><?= $tag['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($this->errors['tags'])) : ?>
            <div class="text-danger">
                <?= $this->errors['tags'] ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <input class="btn btn-primary form-control" type="submit" value="Edit article">
    </div>
</form>
