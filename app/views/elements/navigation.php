<nav class="navbar navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <h1>
                <a class="navbar-brand" href="/home/index"><?= LN_SITE_NAME ?></a>
            </h1>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav">
                <?php if (!empty($this->loggedUser['email']) && $this->loggedUser['role'] === 'admin') : ?>
                    <li>
                        <a href="/posts/index">Posts</a>
                    </li>
                    <li>
                        <a href="/posts/create">Add new post</a>
                    </li>
                    <li>
                        <a href="/users/index">Users</a>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="nav navbar-nav navbar-right">
                <?php if (!empty($this->loggedUser['email'])) : ?>
                    <?= '<li><a href="/users/myprofile">'
                    . $this->loggedUser['email']
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
