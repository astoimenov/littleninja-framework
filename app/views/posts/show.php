<article id="post-<?= $data['id'] ?>">
    <h2><?= $data['title'] ?></h2>

    <div>
        <?= $data['content'] ?>
    </div>
    <hr/>
    <div class="comments">
        <h3>Comments</h3>
        <?php foreach ($data['comments'] as $comment) : ?>
            <dl>
                <dt>
                    <?php if (isset($comment['visitor_name'])) {
                        echo $comment['visitor_name'] . ':';
                    } else {
                        echo $comment['name'] . ':';
                    } ?>
                </dt>
                <dd><?= $comment['content'] ?></dd>
            </dl>
        <?php endforeach; ?>
    </div>
    <div class="comment-form">
        <form method="POST" action="/comments/store" accept-charset="UTF-8">
            <input name="_token" type="hidden" value="">
            <input name="blog_post_id" type="hidden" value="<?= $data['id'] ?>">
            <?php if (empty($this->loggedUser)) : ?>
                <div class="form-group">
                    <label for="name" class="control-label">Name</label>

                    <div class="">
                        <input type="text" class="form-control" name="name" id="name"
                               value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>"/>
                        <?php if (isset($errors['name'])) : ?>
                            <div class="text-danger">
                                <?= $errors['name'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="control-label">E-Mail Address</label>

                    <div class="">
                        <input type="email" class="form-control" name="email" id="email"
                               value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"/>
                        <?php if (isset($errors['email'])) : ?>
                            <div class="text-danger">
                                <?= $errors['email'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="content">Content:</label>
        <textarea class="form-control" name="content"
                  cols="25" rows="5" id="content"><?php
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
                <input class="btn btn-primary form-control" type="submit" value="Add article"/>
            </div>
        </form>
    </div>
</article>
