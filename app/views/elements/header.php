<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>PHP MVC</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/superhero/bootstrap.min.css" />
    <link rel="stylesheet" href="../../../styles/app.css" />
    <link rel="shortcut icon" type="image/png" href="/favicon.png" />
</head>
<body>
    <header>
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
                    <?php if (!empty($this->loggedUser) && $this->loggedUser['role'] === 'admin') : ?>
                    <ul class="nav navbar-nav">
                        <li><a href="posts/index">Posts</a></li>
                        <li><a href="posts/create">Add new post</a></li>
                    </ul>
                    <?php endif; ?>

                    <div class="nav navbar-nav navbar-right">
                        <?php if (!empty($this->logged_user)) {
                            echo '<li><a href="/users/show/' . $this->loggedUser['id'] . '">'
                                . htmlspecialchars($this->loggedUser['email'])
                                . '</a></li>';
                            echo '<li><a href="/auth/logout">Logout</a></li>';
                        } else {
                            echo '<li><a href="/auth/register/" class="text-info">Register</a></li>';
                            echo '<li><a href="/auth/login/" class="text-info">Login</a></li>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main id="main" class="container">
