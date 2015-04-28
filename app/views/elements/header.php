<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP MVC</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/superhero/bootstrap.min.css"/>
    <link rel="stylesheet" href="../../../styles/app.css"/>
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
                    <a class="navbar-brand" href="#">Blog</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="#">Posts</a></li>
                    </ul>

                    <div class="nav navbar-text navbar-right">
                        <?php if (!empty($this->logged_user)) {
                            echo "{$this->logged_user['email']}";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main id="main" class="container">
