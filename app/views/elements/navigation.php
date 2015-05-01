<nav class="navbar navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/home/index">Blog</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav">
                <?php if (!empty($this->loggedUser['email']) && $this->loggedUser['role'] === 'admin') : ?>
                <li>
                    <a class="selected" href="/posts/index">Posts</a>
                </li>
                <li>
                    <a href="/posts/create">Add new post</a>
                </li>
                <?php endif; ?>
            </ul>

            <div class="nav navbar-nav navbar-right">
                <?php if (!empty($this->loggedUser['email'])) : ?>
                    <?= '<li><a href="/users/show/' . $this->loggedUser['id'] . '">'
                    . htmlspecialchars($this->loggedUser['email'], ENT_QUOTES | ENT_HTML5, 'UTF-8')
                    . '</a></li>'
                    . '<li><a href="/auth/logout">Logout</a></li>' ?>
                <?php else : ?>
                    <?= '<li><a href="/auth/register/" class="text-info">Register</a></li>'
                    . '<li><a href="/auth/login/" class="text-info">Login</a></li>'; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
