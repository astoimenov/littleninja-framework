<form method="POST" action="/posts/store" enctype="multipart/form-data" accept-charset="utf-8">
    <input name="_token" type="hidden" value="<?= $_SESSION['csrf_token'] ?>">

    <div class="form-group">
        <label for="title">Title:</label>

        <input class="form-control" name="title" type="text" id="title"
               value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>"/>
        <?php if (isset($this->errors['title'])) : ?>
            <div class="text-danger">
                <?= $this->errors['title'] ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="content">Content:</label>

        <textarea class="form-control" name="content"
                  cols="50" rows="10" id="content"><?php
            if (isset($_POST['content'])) {
                echo $_POST['content'];
            }
            ?></textarea>
        <?php if (isset($this->errors['content'])) : ?>
            <div class="text-danger">
                <?= $this->errors['content'] ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="tags">Tags:</label>

        <select name="tags[]" id="tags" class="form-control" multiple="multiple">
        <?php foreach($data as $tag) : ?>
            <option value="<?= $tag['name'] ?>"><?= $tag['name'] ?></option>
        <?php endforeach; ?>
        </select>
        <?php if (isset($this->errors['tags'])) : ?>
            <div class="text-danger">
                <?= $this->errors['tags'] ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <input class="btn btn-primary form-control" type="submit" value="Add article"/>
    </div>
</form>
