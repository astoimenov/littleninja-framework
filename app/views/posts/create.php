<form method="POST" action="/posts/store" accept-charset="UTF-8">
    <input name="_token" type="hidden" value="">

    <div class="form-group">
        <label for="title">Title:</label>
        <input class="form-control" name="title" type="text" id="title"
            value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>" />
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
        <input class="btn btn-primary form-control" type="submit" value="Add article" />
    </div>
</form>
