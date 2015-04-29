<form method="POST" action="/posts/update" accept-charset="UTF-8">
    <input name="_token" type="hidden" value="FzU5DwntcIawvlO0RU6PapBqBofKmkQHkS6fjdGN">

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
        <input class="btn btn-primary form-control" type="submit" value="Add article">
    </div>
</form>
