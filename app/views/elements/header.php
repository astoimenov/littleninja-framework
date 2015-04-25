<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP MVC</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="artists/index">Artists</a></li>
                <li><a href="#">Blaa</a></li>
            </ul>
        </nav>

        <?php if (!empty($this->logged_user)) : ?>
            echo "Hello, {$this->logged_user['username']}!";
        <?php endif; ?>
    </header>
    <main id="main" class="container">
